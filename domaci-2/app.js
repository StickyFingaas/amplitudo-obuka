const films = [
    {
        watched: false,
        title: "Dune",
        year: 2021,
        country: "USA",
        note: "Film of the year",
        actors: ["Timothee Chalamet", "Oscar Isaac", "Rebecca Ferguson", "Josh Brolin", "Jason Momoa", "Zendaya"]
    },
    {
        watched: false,
        title: "War and Peace",
        year: 1967,
        country: "Russia",
        note: "Grandest epic ever filmed",
        actors: ["Sergei Bondarchuk", "Lyudmila Saveleva", "Vyacheslav Tikhonov"]
    },
    {
        watched: false,
        title: "Paterson",
        year: 2016,
        country: "USA",
        note: "Kylo Ren settles down as a bus driver and discovers poetry",
        actors: ["Adam Driver", "Golshifteh Farahani", "Barry Shabaka Henley"]
    }
]

const formResult = document.getElementById('formResult')
const modalClose = document.getElementById('closeModal')
const filmForm = document.getElementById('filmForm')
filmForm.addEventListener('submit', (e) => {
    e.preventDefault()
    addNewFilm()
})


function getUserInputs(){
    let title = document.getElementById('filmTitle').value
    let year = document.getElementById('filmYear').value
    let country = document.getElementById('filmCountry').value
    let actors = document.getElementById('filmActors').value.split(",")
    let note = document.getElementById('filmNotes').value

    let inputFilm = {
        watched: false,
        title,
        year,
        country,
        actors,
        note
    }


    if(validate(inputFilm).errorMessage)  return {
        errorMessage: validate(inputFilm).errorMessage
    }
    else return inputFilm
}

function validate(inputFilm){
   let result = true
    let errorMessage = ""
   if(!inputFilm.title){
       result = false
       errorMessage += "Enter a film title!"
   }
   if(inputFilm.year < 1930 || inputFilm.year > 2021){
       result = false
       errorMessage += "A year must be between 1930 and 2021!"

   }
   if(inputFilm.actors.length < 1 || !inputFilm.actors[0]){
       result = false
       errorMessage += "Enter at least one actor!"

   }

   if(errorMessage !== "") return {result, errorMessage}
   else return result
}

function addNewFilm(){
    let newFilm = getUserInputs()
    let resultText = '';
    let resultClass = '';
    if(newFilm.errorMessage){
        let errorMsg = newFilm.errorMessage
        formResult.classList.remove('alert-success', 'hidden');
        resultText = `<b>${errorMsg}</b>`;
        resultClass = "alert-danger";
    }
    else{
        newFilm.watched = false
        formResult.classList.remove('alert-danger', 'hidden');
        resultText = "<b>Successful addition!</b>";
        resultClass = "alert-success";
    }
    formResult.innerHTML = resultText
    formResult.classList.add(resultClass)

    if(formResult.innerHTML === "<b>Successful addition!</b>"){
       setTimeout(() => {
           console.log(newFilm);
        formResult.classList.add('hidden')
        modalClose.click()
        films.push(newFilm)
        displayFilmData()
        filmForm.reset()
        checkboxColor()
        getUserInputs()
       }, 2000);
    }
}

function checkboxColor(){
    const checkboxes = document.querySelectorAll('input[type=checkbox]')
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
                let title = checkbox.parentElement.parentElement.children[1].innerHTML
                let condition = (film) => film.title === title
                let index = films.findIndex(condition)
            if(checkbox.checked) {
                checkbox.parentElement.parentElement.style = "background-color: #D1E7DD;"
                films[index].watched = true
            }
            else{
                checkbox.parentElement.parentElement.style = "background-color: #F8D7DA;"
                films[index].watched = false

            }

        })
    })
}

function displayFilmData(){
    const filmsTable = document.querySelector("#tableBody")
    let displayData = []
    films.forEach(film => {
        displayData.push(`<tr style="background-color: #F8D7DA;">
            <td class="text-center"><input type="checkbox" /></td>
            <td>${film.title}</td>
            <td>${film.year}</td>
            <td>${film.country}</td>
            <td>${film.actors}</td>
            <td>${film.note}</td>
        </tr>`)
    })

    filmsTable.innerHTML = displayData.join("")
}

displayFilmData()
checkboxColor()
getUserInputs()