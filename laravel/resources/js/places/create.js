import Validator from '../validator'


// Submit form ONLY when validation is OK
const form = document.getElementById("create-place-form")

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
           "upload": document.getElementsByName("upload")[0].value,
           "name": document.getElementsByName("name")[0].value,
           "description": document.getElementsByName("description")[0].value,
           "latitude": document.getElementsByName("latitude")[0].value,
           "longitude": document.getElementsByName("longitude")[0].value,
       }
       let rules = {
           "upload": "required",
           "name": "required",
           "description": "required",
           "latitude": "required",
           "longitude": "required",
       }
              // Create validation
              let validation = new Validator(data,rules)
              // Validate fields
              if (validation.passes()) {
                  // Allow submit form (do nothing)
                  console.log("Validation OK")
              } else {
                  // Get error messages
                  let errors = validation.errors.all()
                  console.log(errors)
                  // Show error messages
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
       
