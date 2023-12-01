import Validator from '../validator'


// Submit form ONLY when validation is OK
const form = document.getElementById("edit-place-form")

function mostrarError(mensaje, elemento) {
    // Obtener el elemento de mensaje de error
    let mensajeError = document.getElementById(elemento);

    // Mostrar el mensaje de error
    mensajeError.innerHTML = mensaje;
}

if (form) {
   form.addEventListener("submit", function( event ) {
       // Reset errors messages
       // [...]
       // Get form inputs values
       let data = {
        "name": document.getElementsByName("name")[0].value,
        "description": document.getElementsByName("description")[0].value,
        "latitude": document.getElementsByName("latitude")[0].value,
        "longitude": document.getElementsByName("longitude")[0].value,
        }
        let rules = {
            "name": "required",
            "description": "required",
            "latitude": "required",
            "longitude": "required",
        }
              // Create validation
              let validation = new Validator(data,rules)
              // Validate fields
              if (validation.passes()) {
                  console.log("Validation OK")
              } else {
                  let errors = validation.errors.all()
                  console.log(errors)
                  for(let inputName in errors) {     
                        let error = errors[inputName]
                        console.log("[ERROR] " + error)
                        mostrarError(error,  `${inputName}Error`)
                  }
                  // Avoid submit
                  event.preventDefault()
                  return false
              }
          })
       }
       
