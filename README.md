# Application Dockerisée

## Prérequis
1. Docker

## Traitement Vidéo et RabbitMQ
### Aperçu
Cette application Dockerisée illustre un exemple de base pour traiter des vidéos en utilisant RabbitMQ. Toutes les dépendances nécessaires sont incluses dans le conteneur Docker, vous n'avez donc pas besoin de les installer manuellement.

### Comment exécuter

1. **Assurez-vous que Docker est installé** sur votre système. Si ce n'est pas déjà fait, vous pouvez télécharger Docker depuis [le site officiel de Docker](https://www.docker.com/get-started).

2. **Clonez le référentiel du projet** depuis [GitHub].

3. Dans le répertoire du projet, exécutez la commande suivante pour créer et lancer le conteneur Docker : `dockercompose up --build`.

Cette commande va prendre un certain temps pour télécharger et construire les images Docker et configurer l'application.

4. **Attendez que les conteneurs soient prêts** et que l'application soit accessible. Vous verrez des messages indiquant que les conteneurs sont prêts lorsque l'application est prête à être utilisée.

5. **Ouvrez une première fenêtre de votre navigateur** et accédez à l'adresse [http://localhost:80/server.php](http://localhost:80/server.php) pour accéder à la page de traitement vidéo.

6. **Ouvrez une deuxième fenêtre de votre navigateur** et accédez à l'adresse [http://localhost:80/client.php](http://localhost:80/client.php). Cela enverra une vidéo pour être traitée par l'application.

7. **Pour visualiser la vidéo traitée**, accédez à l'adresse [http://localhost:80/video.mp4](http://localhost:80/video.mp4).

C'est tout ! Vous avez réussi à exécuter l'application Dockerisée de traitement vidéo avec RabbitMQ.

## Source
<https://github.com/ProdigyView-Toolkit/Microservices-Examples-PHP>