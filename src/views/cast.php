<section class="admin__login container pt-5">
    <h2 class="text-center text-uppercase mb-5">voter</h2>
    <?php if (isset($erreurs) && count($erreurs) > 0) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php foreach ($erreurs as $value) : ?>
                <?= $value; ?></br>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (isset($success) && count($success) > 0) : ?>
        <div class="alert alert-success text-center" role="alert">
            <?php foreach ($success as $value) : ?>
                <?= $value; ?></br>
            <?php endforeach ?>
        </div>
    <?php endif ?>


    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="card px-5">
                <div class="card-body">
                    <h6 class="card-title text-center mb-4 mt-2">Exprimer votre choix à travers un vote</h6>
                    <form class="px-5" method="post" action="/tp-vote/cast">
                        <div class="row mb-3">
                            <label for="inputState" class="col-sm-4 col-form-label">Candidat</label>
                            <div class="col-sm-8">
                                <select id="inputState" class="form-select" name="candidate_id" required>
                                    <option selected>Choose...</option>

                                    <?php if (isset($data)) : ?>
                                        <?php foreach ($data as $value) : ?>
                                            <option value="<?= $value["candidate_id"]; ?>"> <?= $value["candidate_name"]; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>

                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputvoter_key" class="col-sm-4 col-form-label">Clé pour voter</label>
                            <div class="col-sm-8">
                                <input type="text" name="voter_key" class="form-control" id="inputvoter_key" >
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Voter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>