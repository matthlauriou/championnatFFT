var dialog;
window.onload = function exampleFunction() {
    dialog = document.getElementById('myModal');
    var btn = document.getElementsByClassName('openModal');
    var span = document.getElementById('close');

    var cancelButton = document.getElementById('cancel');

    for (let element of btn) {
        element.addEventListener('click', function () {
            dialog.showModal();
            openCheck(dialog);
        });
    }

    span.onclick = function () {
        dialog.close();
    }

    window.onclick = function (event) {
        if (event.target == dialog) {
            dialog.close();
        }
    }

    function openCheck(dialog) {
        if (dialog.open) {
            console.log('Dialog open');
        } else {
            console.log('Dialog closed');
        }
    }

    cancelButton.addEventListener('click', function () {
        dialog.close('animalNotChosen');
        openCheck(dialog);
    });
}

function openModal(id) {
    const idField = dialog.querySelector('input[name="id"]');
    idField.value = id;
    idModal = dialog.querySelector('#idModal');
    idModal.innerHTML = id;
}

function supprimerEquipe() {
    const idField = dialog.querySelector('input[name="id"]');
    const id = idField.value;
    location.replace(`?page=gestionEquipe&action=supprimer&idEquipe=${id}`);
    dialog.close();
}