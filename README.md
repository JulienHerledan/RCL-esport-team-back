# RCL eSport Team

## Description

## Routes

| Route              | Méthode |  Controller | Description                                                                                                               | Usable ? |
|--------------------|---------|---------------------------------------------------------------------------------------------------------------------------|----------|-----------|
| /api/articles      | GET     |  ArticleController | Récupérer la liste des articles                                                                                           | YES      |
| /api/articles/{id} | GET     |ArticleController|  ArticleController |  Récupérer un article spécifique                                                                                           | YES      |
| /api/comments      | POST    | CommentController |Créer un commentaire <br/> Doit contenir les champs "article" (id de l'article) et "message" (message du commentaire)     | YES       |
| /api/matches       | GET     | MatcheController |Récupérer la liste des matchs                                                                                             | YES      |
| /api/members       | GET     | MemberController |Récupérer la liste des membres de notre équipe                                                                            | YES      |
| /api/users         | POST    | UserController |Création d'un utilisateur (Inscription) Doit contenir les champs "nickname", "email" et "password". Role par défaut: User | YES      |
| /api/users/check   | GET     | UserController |Vérifie si le token est expiré. Si expiré: "401 Expired JWT Token", sinon "200 JWT Token still valid"                     | YES      |
| /api/users         | PATCH   | UserController |Changer les informations d'un user.  Doit contenir l'un des 3 champs ou les 3 champs: "email", "password", "nickname",   | YES      |
| /api/users         | DELETE  | UserController |Supprimer un user.  Doit contenir les champs "email", "password",                                                         | NO       |
| /api/users         | PATCH   | UserController |Changer les infosrmations d'un user.  Doit contenir l'un des 3 champs ou les 3 champs: "email", "password", "nickname",   | YES      |
| /api/users         | DELETE  | UserController |Supprimer un user.    
| /api/video-clips   | GET     | VideoClipController |Récupérer la liste des video clips                                                                                        | YES      |
| /api/apply         | POST    | ApllyController |Créer une candidature dans la base de donnée.  Doit contenir les champs "name", "email", "phoneNumber", "presentation".   | NO       |

