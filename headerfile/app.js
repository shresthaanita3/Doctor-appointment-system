
    const model = document.querySelector('.model');
    const add = document.querySelector('.add-schedule');
    const close = document.querySelector('.close-schedule');
    const dialog = document.getElementById('doctor');

    function imgClicked() {
        dialog.showModal();
        model.close(); // Close the other dialog
    }

    function closedialog() {
        dialog.close();
    }
    add.addEventListener('click', () => {
        model.showModal();
        dialog.close(); // Close the other dialog
    });

    close.addEventListener('click', () => {
        model.close();
    });

    // Add event listener for the close button inside the doctor dialog
    const doctorCloseBtn = document.querySelector('.doctor button');
    doctorCloseBtn.addEventListener('click', () => {
        dialog.close();
    });