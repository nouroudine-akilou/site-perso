document.addEventListener('DOMContentLoaded', (event) => {
    // Sélectionner l'élément du bouton et l'élément de la valeur
    const incrementButton = document.getElementById('incrementButton');
    const valueElement = document.getElementById('value');

    // Initialiser la valeur et une variable pour suivre l'état
    let value = 0;
    let increment = true; // Utilisé pour alterner entre incrémentation et décrémentation

    // Ajouter un écouteur d'événement pour le clic sur le bouton
    incrementButton.addEventListener('click', () => {
        // Incrémenter ou décrémenter la valeur en fonction de l'état actuel
        if (increment) {
            value++;
        } else {
            value--;
        }

        // Mettre à jour le texte de l'élément de la valeur
        valueElement.textContent = value;

        // Alterner l'état pour la prochaine opération
        increment = !increment;
    });
});
