Le code suivant est un Bundle pour Symfony 2 proposant divers outils pour des cours d'anglais. Il permet notamment de :

* traduire, de manière collaborative, des termes de l'anglais vers le français et vice-versa
* des quizzs et jeu sur les mots traduits (à implémenter)

Pour l'installer : 

- Installez Symfony et les vendeurs
- Initialisez git dans le répertoire de Symfony
```bash
git init
```
- Importez les sources : 
```bash
#git remote add github git://github.com/julienfastre/AnglaisTech.git
#git pull github master
```
- Adaptez la configuration à votre installation: 
```bash
#cp app/config/parameters.bak.ini app/config/parameters.ini
#vi app/config/parameters.ini
```
- Installez la base de donnée :
```bash
#php app/console doctrine:schema:create --force
```

Amusez-vous ! 

L'auteur peut être contacté à l'adresse suivante: julienfastre@cvfe.be