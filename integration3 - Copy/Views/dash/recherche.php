<?php

include_once "../../controller/achatA.php";

$achatManager = new AchatManager();
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($searchTerm)) {
    // Recherche par nom d'utilisateur
    $achats = $achatManager->searchAchatsByUserName($searchTerm);
} else {
    // Afficher tous les achats si aucun terme n'est recherché
    $achats = $achatManager->listAchats();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Syncora Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="styles/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #355ccc;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;

        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        
        .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .buttons button {
            margin: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
<style>
.img {
    width: 80px; /* Adjust to your preferred size */
    height: 50px; /* Maintain a square aspect ratio */
    border-radius: 80%; /* Circular shape */
    overflow: hidden; /* Ensures the image fits within the circle */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08); /* Adds a soft shadow */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover animations */
    margin-right:80px;
}

.img img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image fills the circle */
}

.img:hover {
    transform: scale(1.1); /* Slightly zoom in on hover */
    box-shadow: 0 8px 10px rgba(0, 0, 0, 0.15), 0 3px 6px rgba(0, 0, 0, 0.12); /* Stronger shadow on hover */
}

    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
       
       <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
           <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dash.html">
              
               <div class="img">
                <img src="imgggg.png" alt="syncauralogo">
               </div>
           </a>
       <hr class="sidebar-divider my-0">
       <li class="nav-item active">
           <a class="nav-link" href="dash.php">
               <i class="fas fa-fw fa-tachometer-alt"></i>
               <span>Dashboard</span>
           </a>
       </li>
       <hr class="sidebar-divider">
       <div class="sidebar-heading">
           Tables
       </div>
       <li class="nav-item">
       <a class="nav-link" href="admin/admin_dasboard/users.php">
               <i class="fas fa-fw fa-cog"></i>
               <span>Users</span>
           </a>
           <a class="nav-link collapsed" href="table_Chatuser.php" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
               <i class="fas fa-fw fa-cog"></i>
               <span>Chat users</span>
           </a>
           <a class="nav-link collapsed" href="table_messages.php" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
               <i class="fas fa-fw fa-cog"></i>
               <span>Chat messages</span>
           </a>
           <a class="nav-link collapsed" href="fetch.php" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
               <i class="fas fa-fw fa-cog"></i>
               <span>users and messages </span>
           </a>
           <a class="nav-link collapsed" href="listPack.php" data-toggle="collapse" data-target="#collapseUtilities"
               aria-expanded="true" aria-controls="collapseUtilities">
               <i class="fas fa-fw fa-wrench"></i>
               <span>Gestion Packs</span>
           </a>
           <a class="nav-link collapsed" href="recherche.php" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
           <i class="fas fa-fw fa-wrench"></i>
           <span>recherche  Achats</span>
       </a>
       <a class="nav-link collapsed" href="ai pack.php" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
           <i class="fas fa-fw fa-wrench"></i>
           <span>ai description pack</span>
       </a>

       <a class="nav-link collapsed" href="send.php" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
           <i class="fas fa-fw fa-wrench"></i>
           <span>Mailing</span>
       </a>
       <a class="nav-link collapsed" href="listAchat.php" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
           <i class="fas fa-fw fa-wrench"></i>
           <span>Gestion Achats</span>
       </a>
       <a class="nav-link collapsed" href="dashboard.php" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
           <i class="fas fa-fw fa-wrench"></i>
           <span>Blog</span>
       </a>
            <a class="nav-link collapsed" href="dash_todo/plandash.php" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Manage Plans </span>
            </a>
            <a class="nav-link collapsed" href="dash_todo/taskdash.php" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Manage Tasks </span>
            </a>
            <a class="nav-link collapsed" href="dash_todo/searchtaskdash.php" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Search Tasks </span>
            </a>
   </ul>

<?php include 'admin_header.php'; ?>->

<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
        </nav>
    <center>
        <h1>Recherche des Achats</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Rechercher par nom d'utilisateur" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Rechercher</button>
        </form>
    </center>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Utilisateur</th>
                <th>Email</th>
                <th>Pack</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($achats)): ?>
                <?php foreach ($achats as $achat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($achat['ida']); ?></td>
                        <td><?php echo htmlspecialchars($achat['nom_user']); ?></td>
                        <td><?php echo htmlspecialchars($achat['email']); ?></td>
                        <td><?php echo htmlspecialchars($achat['idPack']); ?></td>
                        <td>
                           
                            <a href="deleteAchat.php?id=<?php echo $achat['ida']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun achat trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="buttons">
        <button onclick="window.location.href='listAchat.php'">Retour</button>
    </div>
</body>

</html>


