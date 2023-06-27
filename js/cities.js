document.addEventListener("DOMContentLoaded", async () => {
    const url = "http://localhost/SkylAb-179/campus_tables/uploads/city";
    const form = document.getElementById("myForm");
  
    // Cargar datos al cargar la página
    const loadData = async () => {
      try {
        const response = await fetch(url);
        const data = await response.json();
  
        const tabla = document.querySelector("#tbArea");
        let plantilla = "";
  
        data.forEach((val) => {
          plantilla += `
            <tr>
                <th scope="row">${val.id}</th>
                <td>${val.name_city}</td>
                <td>${val.id_region}</td>
                <td>
                  <button class="btn btn-primary edit" data-id="${val.id}" data-name="${val.name_city,val.id_region}">Editar</button>
                  <button class="btn btn-danger delete" data-id="${val.id}">Eliminar</button>
                </td>
            </tr>
          `;
        });
  
        tabla.insertAdjacentHTML("beforeend", plantilla);
      } catch (error) {
        console.error("Error:", error);
      }
    };
  
    loadData();

    // (POST)
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      e.stopPropagation();
  
      const name_city = document.getElementById("name_city").value;
      const id_region = document.getElementById("id_region").value;

  
      try {
        const response = await fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ name_city: name_city, id_region : id_region }),
        });
  
        if (!response.ok) {
          throw new Error("Error en la solicitud");
        }
  
        location.reload();
      } catch (error) {
        console.error("Error:", error);
      }
    });
    // (PUT)
    document.addEventListener("click", async (e) => {
        if (e.target.classList.contains("edit")) {
          const id = e.target.dataset.id;
          const name = e.target.dataset.name;
      
          const newName = prompt("Ingrese el nuevo nombre:", name);
      
          if (newName) {
            try {
              const response = await fetch(`${url}/${id}`, {
                method: "PUT",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({ name_area: newName }),
              });
      
              if (!response.ok) {
                throw new Error("Error en la solicitud");
              }
      
              location.reload();
            } catch (error) {
              console.error("Error:", error);
            }
          }
        }
      });
    // (DELETE)
    document.addEventListener("click", async (e) => {
      if (e.target.matches(".delete")) {
        const id = e.target.dataset.id;
  
        try {
          const response = await fetch(`${url}/${id}`, {
            method: "DELETE",
          });
  
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
  
          location.reload();
        } catch (error) {
          console.error("Error:", error);
        }
      }
    });
  });
  