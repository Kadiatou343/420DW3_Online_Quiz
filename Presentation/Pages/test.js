document.addEventListener('DOMContentLoaded', function() { 

    console.log("Le script est bien charge");
        // Selection de tous les elements avec la classe .ans (des liens le cas présent)
        const answers = document.querySelectorAll('.ans');

        // Recuperation de l'id de la questions de la balise invisible
        let quesId = document.getElementById('quesId');

        // Ajout de l'événement 'click' avec envoie de la requete ajax

        answers.forEach(answer => {
            answer.addEventListener('click', function(event){
                event.preventDefault();
                let value = this.textContent;
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            let reponse = xhr.responseText;
                        }
                        else {
                            console.log("Erreur : " + xhr.status + " " + xhr.statusText);
                        }
                    }
                }
                xhr.open("GET", "gamerQuiz.php?answer=" + encodeURIComponent(value) + "&quesId=" +encodeURIComponent(quesId), true);
                xhr.send();
            });
        });


        const play = document.getElementById('play')
        const endQuiz = document.getElementById('endQuiz');
        const game = document.getElementById('game');
        const result = document.getElementById('result');

         /*Faire apparaitre la fenetre de jeu */
        play.addEventListener('click', function(event) {
            event.preventDefault();
            console.log("Click detecte");
            game.style.display = 'flex';
            game.style.flexDirection = 'row';
            game.style.justifyContent = 'center';
        });
        
        /*Faire apparaitre la fenetre de resultats */
        endQuiz.addEventListener('click', function(event){
            event.preventDefault();
            game.style.display = 'flex';
            game.style.flexDirection = 'row';
            game.style.justifyContent = 'center';
        });

});