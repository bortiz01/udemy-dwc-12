document.addEventListener("DOMContentLoaded", function () {
  "use strict";

  /* ---------------------------- global constans ---------------------------- */
  const formContact = document.querySelector("#contact");
  const listContacts = document.querySelector("#list-contacts tbody");
  const inputSearch = document.querySelector("#search");

  eventListeners();

  /* -------------------------------- functions ------------------------------- */
  function eventListeners() {
    // cuando se llena un formulario (crear o editar)
    if (formContact) {
      formContact.addEventListener("submit", readForm);
    }

    // cuando se da click en algun elemento
    if (listContacts) {
      listContacts.addEventListener("click", deleteContact);
    }

    // cuando se ingresan valores
    if (inputSearch) {
      inputSearch.addEventListener("input", searchContact);
    }

    numContacts();
  }

  function readForm(e) {
    // IMPORTANTE: previene la accion por defecto. Util cuando se realiza el proceso por JS o AJAX
    e.preventDefault();

    // leer los datos del formulario
    const name = document.querySelector("#nombre").value,
      empresa = document.querySelector("#empresa").value,
      telefono = document.querySelector("#telefono").value,
      accion = document.querySelector("#accion").value;

    if (name === "" || empresa === "" || telefono === "") {
      showNotification("Todos los campos son obligatorios", "error");
    } else {
      // pasa la validacion, crear llamado a Ajax
      const infoContact = new FormData();
      infoContact.append("nombre", name);
      infoContact.append("empresa", empresa);
      infoContact.append("telefono", telefono);
      infoContact.append("accion", accion);

      // console.log(...infoContact);

      if (accion === "crear") {
        // creamos el nuevo contacto
        insertContact(infoContact);
      } else {
        // modificamos el contacto existente
        const idContact = document.querySelector("#id").value;
        infoContact.append("id", idContact);
        updateContact(infoContact);
      }
    }
  }

  // insertar en la base de datos
  function insertContact(p_data) {
    // llamado a AJAX
    // crear el objeto
    const xhr = new XMLHttpRequest();

    // abrir la conexion
    xhr.open("POST", "includes/models/model-contacts.php", true);

    // pasar los datos (es lo que se hara con la informacion recibida)
    xhr.onload = function () {
      if (this.status === 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response);

        // insertar un nuevo elemento en la tabla
        const newContact = document.createElement("tr");
        newContact.innerHTML = `
          <td>${response.data.nombre}</td>
          <td>${response.data.empresa}</td>
          <td>${response.data.telefono}</td>
        `;

        // crear contenedor para los botones
        const containerActions = document.createElement("td");

        // crear el icono de editar
        const iconEdit = document.createElement("i");
        iconEdit.classList.add("fas", "fa-pen-square");

        // crear el boton de editar
        const btnEdit = document.createElement("a");
        btnEdit.appendChild(iconEdit);
        btnEdit.href = `edit.php?id=${response.data.id}`;
        btnEdit.classList.add("btn", "btn-edit");

        // agregar el boton al padre
        containerActions.appendChild(btnEdit);

        // crear el icono de eliminar
        const iconDelete = document.createElement("i");
        iconDelete.classList.add("fas", "fa-trash-alt");

        // crear el boton de editar
        const btnDelete = document.createElement("button");
        btnDelete.appendChild(iconDelete);
        btnDelete.setAttribute("data-id", response.data.id);
        btnDelete.setAttribute("type", "button");
        btnDelete.classList.add("btn", "btn-delete");

        // agregar el boton al padre
        containerActions.appendChild(btnDelete);

        // agregarlo al tr
        newContact.appendChild(containerActions);

        // agregarlo con los contactos
        listContacts.appendChild(newContact);

        // resetear el form
        document.querySelector("form").reset();
        document.querySelector("#nombre").focus();

        // mostrar notificacion
        showNotification("Contacto creado correctamente", "success");

        // actualizamos el contador de contactos
        numContacts();
      }
    };

    // enviar los datos
    xhr.send(p_data);
  }

  // actualizamos el registro del contacto
  function updateContact(p_data) {
    // ver la informacion que recibe del FormData
    // console.log(...p_data);
    // crear el objeto
    const xhr = new XMLHttpRequest();

    // abrir la conexion
    xhr.open("POST", "includes/models/model-contacts.php", true);

    // leer la respuesta
    xhr.onload = function () {
      if (this.status === 200) {
        const response = JSON.parse(xhr.responseText);

        if (response.response == "success") {
          // mostrar una notificacion
          showNotification("Contacto actualizado exitosamente", "success");
        } else {
          // mostrar una notificacion
          showNotification("Ocurrio un error...", "error");
        }

        setTimeout(() => {
          window.location.href = "index.php";
        }, 3000);
      }
    };

    // enviar la peticion
    xhr.send(p_data);
  }

  // eliminar el contacto seleccionado
  function deleteContact(e) {
    // navegar hacia el padre para ubicar el id del contacto
    if (e.target.parentElement.classList.contains("btn-delete")) {
      const id = e.target.parentElement.getAttribute("data-id");
      // console.log(id);
      const resp = confirm("Estas seguro de eliminar el contacto?");
      if (resp) {
        // llamdo al ajax
        // crear el objeto
        const xhr = new XMLHttpRequest();

        // abrir la conexion
        xhr.open("GET", `includes/models/model-contacts.php?id=${id}&accion=borrar`, true);

        // leer la respuesta
        xhr.onload = function () {
          if (this.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.response == "success") {
              // eliminar registro del DOM
              e.target.parentElement.parentElement.parentElement.remove();

              // mostrar una notificacion
              showNotification("Contacto eliminado", "success");

              // actualizamos el contador de contactos
              numContacts();
            } else {
              // mostrar una notificacion
              showNotification("Hubo un error...", "error");
            }
          }
        };

        // enviar la peticion
        xhr.send();
      }
    }
  }

  // buscador de registros
  function searchContact(e) {
    const expression = new RegExp(e.target.value, "i");
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach((row) => {
      row.style.display = "none";

      if (row.childNodes[1].textContent.replace(/\s/g, " ").search(expression) != -1) {
        row.style.display = "table-row";
      }
    });

    numContacts();
  }

  // muestra el numero de contactos
  function numContacts() {
    const totalContacts = document.querySelectorAll("tbody tr");
    const containerNum = document.querySelector(".total-contacts span");

    if (containerNum) {
      let total = 0;

      totalContacts.forEach((contact) => {
        if (contact.style.display === "" || contact.style.display === "table-row") {
          total++;
        }
      });

      containerNum.textContent = total;
    }
  }

  // notificacion en pantalla
  function showNotification(p_message, p_typeMessage) {
    const lc_notification = document.createElement("div");
    lc_notification.classList.add("notification", p_typeMessage, "shadow");
    lc_notification.textContent = p_message;

    // form
    formContact.insertBefore(lc_notification, document.querySelector("form legend"));

    // show and hide notif
    setTimeout(() => {
      lc_notification.classList.add("visible");

      setTimeout(() => {
        lc_notification.classList.remove("visible");

        setTimeout(() => {
          lc_notification.remove();
        }, 500);
      }, 3000);
    }, 10);
  }
});
