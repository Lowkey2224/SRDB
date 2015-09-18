<!doctype html>
<html ng-app="project">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.7/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.7/angular-resource.min.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.7/angular-route.min.js">
    </script>
    <script src="https://cdn.firebase.com/v0/firebase.js"></script>
    <script src="https://cdn.firebase.com/libs/angularfire/0.5.0/angularfire.min.js"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/lokicharacter/js/todo.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/lokicharacter/css/bootstrap.css') ?>">
</head>
<body>
<h2>JavaScript Projects</h2>
<div ng-view></div>
</body>
</html>