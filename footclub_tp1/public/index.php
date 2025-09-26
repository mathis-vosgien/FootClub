<?php
// public/index.php
declare(strict_types=1);

spl_autoload_register(function($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

use App\Repositories\{PlayerRepository,TeamRepository,OpponentClubRepository,StaffRepository,MatchRepository,TeamPlayerRoleRepository};
use App\Entities\{Player,Team,OpponentClub,Staff,MatchGame,TeamPlayerRole};


$config = require __DIR__ . '/../config/config.php';
$baseUrl = rtrim($config['app']['base_url'], '/') . '/';

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'list';

function handle_upload(string $field, string $uploadDir): ?string {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
    $name = uniqid('img_', true) . ($ext ? '.' . $ext : '');
    if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
    move_uploaded_file($_FILES[$field]['tmp_name'], $uploadDir . '/' . $name);
    return $name;
}

?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FootClub ⚽</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?php echo h($baseUrl); ?>footclub_tp1/public/index.php">FootClub</a>
    <div class="navbar-nav">
      <a class="nav-link" href="?page=players">Joueurs</a>
      <a class="nav-link" href="?page=teams">Équipes</a>
      <a class="nav-link" href="?page=matches">Matchs</a>
      <a class="nav-link" href="?page=opponents">Clubs adverses</a>
      <a class="nav-link" href="?page=staff">Staff</a>
    </div>
  </div>
</nav>
<div class="container">

<?php if ($page === 'home'): ?>
  <div class="p-5 bg-light rounded-3">
    <h1 class="display-6">Bienvenue sur FootClub</h1>
    <p class="lead">Gérez vos joueurs, équipes, matchs, clubs adverses et staff.</p>
    <p>Commencez par <a href="?page=players">ajouter des joueurs</a> et <a href="?page=teams">créer des équipes</a>.</p>
  </div>
<?php endif; ?>

<?php
// PLAYERS
if ($page === 'players') {
    $repo = new PlayerRepository();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $photo = handle_upload('photo', $config['app']['upload_dir']);
        $p = new Player($_POST['first_name'] ?? '', $_POST['last_name'] ?? '', $_POST['birthdate'] ?? null, $photo);
        $repo->create($p);
        echo '<div class="alert alert-success">Joueur créé.</div>';
    }
    if ($action === 'delete' && isset($_GET['id'])) {
        $repo->delete((int)$_GET['id']);
        echo '<div class="alert alert-warning">Joueur supprimé.</div>';
    }
    $players = $repo->all();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Joueurs</h2>
    </div>
    <form class="row g-2 mb-4" method="post" enctype="multipart/form-data">
      <div class="col-sm-3"><input required name="first_name" class="form-control" placeholder="Prénom"></div>
      <div class="col-sm-3"><input required name="last_name" class="form-control" placeholder="Nom"></div>
      <div class="col-sm-3"><input type="date" name="birthdate" class="form-control" placeholder="Date de naissance"></div>
      <div class="col-sm-3"><input type="file" name="photo" class="form-control"></div>
      <div class="col-12"><button class="btn btn-primary">Ajouter</button></div>
    </form>
    <table class="table table-striped">
      <thead><tr><th>Photo</th><th>Nom</th><th>Date de naissance</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($players as $pl): ?>
        <tr>
          <td><?php if ($pl['photo']): ?><img src="uploads/<?php echo h($pl['photo']); ?>" width="48"><?php endif; ?></td>
          <td><?php echo h($pl['last_name'] . ' ' . $pl['first_name']); ?></td>
          <td><?php echo h($pl['birthdate']); ?></td>
          <td class="text-end"><a class="btn btn-sm btn-outline-danger" href="?page=players&action=delete&id=<?php echo h($pl['id']); ?>" onclick="return confirm('Supprimer ?')">Supprimer</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php
}

// TEAMS
if ($page === 'teams') {
    $trepo = new TeamRepository();
    $prepo = new PlayerRepository();
    $tprepo = new TeamPlayerRoleRepository();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'create')) {
        $t = new Team($_POST['name'] ?? '', $_POST['category'] ?? null);
        $trepo->create($t);
        echo '<div class="alert alert-success">Équipe créée.</div>';
    }
    if ($action === 'delete' && isset($_GET['id'])) {
        $trepo->delete((int)$_GET['id']);
        echo '<div class="alert alert-warning">Équipe supprimée.</div>';
    }
    $teams = $trepo->all();
    ?>
    <h2 class="mb-3">Équipes</h2>
    <form class="row g-2 mb-4" method="post" action="?page=teams&action=create">
      <div class="col-sm-6"><input required name="name" class="form-control" placeholder="Nom de l'équipe"></div>
      <div class="col-sm-4"><input name="category" class="form-control" placeholder="Catégorie (U18, Seniors, etc.)"></div>
      <div class="col-sm-2"><button class="btn btn-primary w-100">Ajouter</button></div>
    </form>
    <div class="row">
      <?php foreach ($teams as $t): ?>
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0"><?php echo h($t['name']); ?> <small class="text-muted"><?php echo h($t['category']); ?></small></h5>
              <a class="btn btn-sm btn-outline-danger" href="?page=teams&action=delete&id=<?php echo h($t['id']); ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </div>
            <hr>
            <h6>Effectif</h6>
            <form class="row g-2" method="post" action="?page=teams&action=assign&team_id=<?php echo h($t['id']); ?>">
              <div class="col-5">
                <select name="player_id" class="form-select">
                  <?php foreach ($prepo->all() as $p): ?>
                    <option value="<?php echo h($p['id']); ?>"><?php echo h($p['last_name'].' '.$p['first_name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-4"><input name="role" class="form-control" placeholder="Rôle (attaquant, milieu, ...)"></div>
              <div class="col-3"><button class="btn btn-secondary w-100">Affecter</button></div>
            </form>
            <?php
              if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'assign' && (int)($_GET['team_id'] ?? 0) === (int)$t['id']) {
                  $tprepo->assign(new TeamPlayerRole((int)$t['id'], (int)($_POST['player_id'] ?? 0), $_POST['role'] ?? ''));
                  echo '<div class="alert alert-info mt-2">Affectation mise à jour.</div>';
              }
            ?>
            <ul class="list-group list-group-flush mt-2">
              <?php foreach ($tprepo->forTeam((int)$t['id']) as $m): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?php echo h($m['last_name'].' '.$m['first_name']); ?> — <em><?php echo h($m['role']); ?></em></span>
                <a class="btn btn-sm btn-outline-secondary" href="?page=teams&action=unassign&team_id=<?php echo h($t['id']); ?>&player_id=<?php echo h($m['player_id']); ?>">Retirer</a>
              </li>
              <?php endforeach; ?>
            </ul>
            <?php
              if ($action === 'unassign' && (int)($_GET['team_id'] ?? 0) === (int)$t['id'] && isset($_GET['player_id'])) {
                  $tprepo->unassign((int)$t['id'], (int)$_GET['player_id']);
                  echo '<div class="alert alert-warning mt-2">Joueur retiré.</div>';
              }
            ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php
}

// OPPONENT CLUBS
if ($page === 'opponents') {
    $repo = new OpponentClubRepository();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $repo->create(new OpponentClub($_POST['name'] ?? '', $_POST['city'] ?? '', $_POST['country'] ?? ''));
        echo '<div class="alert alert-success">Club ajouté.</div>';
    }
    if ($action === 'delete' && isset($_GET['id'])) {
        $repo->delete((int)$_GET['id']);
        echo '<div class="alert alert-warning">Club supprimé.</div>';
    }
    $clubs = $repo->all();
    ?>
    <h2 class="mb-3">Clubs adverses</h2>
    <form class="row g-2 mb-4" method="post">
      <div class="col-sm-4"><input required name="name" class="form-control" placeholder="Nom du club"></div>
      <div class="col-sm-3"><input name="city" class="form-control" placeholder="Ville"></div>
      <div class="col-sm-3"><input name="country" class="form-control" placeholder="Pays"></div>
      <div class="col-sm-2"><button class="btn btn-primary w-100">Ajouter</button></div>
    </form>
    <table class="table table-striped">
      <thead><tr><th>Nom</th><th>Ville</th><th>Pays</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($clubs as $c): ?>
        <tr>
          <td><?php echo h($c['name']); ?></td>
          <td><?php echo h($c['city']); ?></td>
          <td><?php echo h($c['country']); ?></td>
          <td class="text-end"><a class="btn btn-sm btn-outline-danger" href="?page=opponents&action=delete&id=<?php echo h($c['id']); ?>" onclick="return confirm('Supprimer ?')">Supprimer</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php
}

// STAFF
if ($page === 'staff') {
    $repo = new StaffRepository();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $photo = handle_upload('photo', $config['app']['upload_dir']);
        $repo->create(new Staff($_POST['first_name'] ?? '', $_POST['last_name'] ?? '', $_POST['role'] ?? '', $photo));
        echo '<div class="alert alert-success">Membre du staff ajouté.</div>';
    }
    if ($action === 'delete' && isset($_GET['id'])) {
        $repo->delete((int)$_GET['id']);
        echo '<div class="alert alert-warning">Membre supprimé.</div>';
    }
    $staff = $repo->all();
    ?>
    <h2 class="mb-3">Staff</h2>
    <form class="row g-2 mb-4" method="post" enctype="multipart/form-data">
      <div class="col-sm-3"><input required name="first_name" class="form-control" placeholder="Prénom"></div>
      <div class="col-sm-3"><input required name="last_name" class="form-control" placeholder="Nom"></div>
      <div class="col-sm-3"><input required name="role" class="form-control" placeholder="Rôle (coach, kiné, ...)"></div>
      <div class="col-sm-3"><input type="file" name="photo" class="form-control"></div>
      <div class="col-12"><button class="btn btn-primary">Ajouter</button></div>
    </form>
    <div class="row">
    <?php foreach ($staff as $s): ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <?php if ($s['photo']): ?>
            <img src="uploads/<?php echo h($s['photo']); ?>" class="card-img-top" alt="photo">
          <?php endif; ?>
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title mb-0"><?php echo h($s['last_name'].' '.$s['first_name']); ?></h5>
              <p class="card-text"><small class="text-muted"><?php echo h($s['role']); ?></small></p>
            </div>
            <a class="btn btn-sm btn-outline-danger" href="?page=staff&action=delete&id=<?php echo h($s['id']); ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
    <?php
}

// MATCHES
if ($page === 'matches') {
    $mrepo = new MatchRepository();
    $trepo = new TeamRepository();
    $orepo = new OpponentClubRepository();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $m = new MatchGame(
            (int)($_POST['team_id'] ?? 0),
            (int)($_POST['opponent_club_id'] ?? 0),
            $_POST['city'] ?? '',
            $_POST['match_date'] ?? date('Y-m-d'),
            (int)($_POST['home_score'] ?? 0),
            (int)($_POST['away_score'] ?? 0)
        );
        $mrepo->create($m);
        echo '<div class="alert alert-success">Match ajouté.</div>';
    }
    if ($action === 'delete' && isset($_GET['id'])) {
        $mrepo->delete((int)$_GET['id']);
        echo '<div class="alert alert-warning">Match supprimé.</div>';
    }
    $matches = $mrepo->all();
    ?>
    <h2 class="mb-3">Matchs</h2>
    <form class="row g-2 mb-4" method="post">
      <div class="col-sm-3">
        <select class="form-select" name="team_id">
          <?php foreach ($trepo->all() as $t): ?>
            <option value="<?php echo h($t['id']); ?>"><?php echo h($t['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-3">
        <select class="form-select" name="opponent_club_id">
          <?php foreach ($orepo->all() as $o): ?>
            <option value="<?php echo h($o['id']); ?>"><?php echo h($o['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-2"><input class="form-control" name="city" placeholder="Ville"></div>
      <div class="col-sm-2"><input type="date" class="form-control" name="match_date" value="<?php echo date('Y-m-d'); ?>"></div>
      <div class="col-sm-1"><input class="form-control" name="home_score" type="number" min="0" placeholder="Nous"></div>
      <div class="col-sm-1"><input class="form-control" name="away_score" type="number" min="0" placeholder="Eux"></div>
      <div class="col-12"><button class="btn btn-primary">Ajouter</button></div>
    </form>
    <table class="table table-hover">
      <thead><tr><th>Date</th><th>Ville</th><th>Équipe</th><th>Adversaire</th><th>Score</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($matches as $m): ?>
        <tr>
          <td><?php echo h($m['match_date']); ?></td>
          <td><?php echo h($m['city']); ?></td>
          <td><?php echo h($m['team_name']); ?></td>
          <td><?php echo h($m['opponent_name']); ?></td>
          <td><?php echo h($m['home_score'] . ' - ' . $m['away_score']); ?></td>
          <td class="text-end"><a class="btn btn-sm btn-outline-danger" href="?page=matches&action=delete&id=<?php echo h($m['id']); ?>" onclick="return confirm('Supprimer ?')">Supprimer</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php
}
?>

</div>
</body>
</html>
