<section class="container mt-5">
  <?php if (isset($data["erreurs"])) : ?>
    <div class="alert alert-danger text-center" role="alert">
      <?php foreach ($data["erreurs"] as $value) : ?>
        <?= $value; ?></br>
      <?php endforeach ?>
    </div>
  <?php endif ?>

  <div class="row">
    <div class="col-12 col-md-6">
      <div class="d-flex justify-content-center">
        <table class="table table-bordered table-striped">
          <?php
          if ($session->has("voter_info")) {
            $el = $session->get('voter_info')[0];

            print <<<EOT
           <tr>
             <th scope="col" class="text-uppercase">ID</th>
             <td class="text-uppercase" >{$el["voter_id"]}</td>
           </tr>
           <tr>
             <th scope="col" class="text-uppercase">username</th>
             <td class="text-uppercase">{$el["username"]}</td>
           </tr>
           <tr>
             <th scope="col" class="text-uppercase">Cni</th>
             <td>{$el["cni"]}</td>
          </tr>
          <tr>
             <th scope="col" class="text-uppercase">Mobile</th>
             <td>{$el["contact_no"]}</td>
          </tr>
EOT;
          }
          ?>
        </table>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="card-body">
        <h5 class="card-title text-center">Génerer une nouvelle clé</h5>
        <form class="mt-3" method="post" action="/tp-vote/profil">
          <div class="row mb-3">
            <input type="text" name="voter_id" class="form-control" 
                         value="<?php if ($session->has("voter_info")) : ?>
                                  <?= $session->get("voter_info")[0]["voter_id"]; ?>  
                                <?php endif ?>" id="inputID" 
            hidden required>
            <label for="input" class="col-sm-3 col-form-label">clé pour voter</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="input" value=" <?php if (isset($data["success"])) : ?><?= $data["success"][0]; ?> <?php endif ?>" disabled>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Génerer</button>
        </form>

      </div>
    </div>
  </div>
</section>