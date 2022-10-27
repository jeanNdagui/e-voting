<section class="candidate__add container pt-5">

    <?php if (isset($data["erreurs"])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php foreach ($data["erreurs"] as $value) : ?>
                <?= $value; ?></br>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (isset($data["success"])) : ?>
        <div class="alert alert-success text-center" role="alert">
            <?php foreach ($data["success"] as $value) : ?>
                <?= $value; ?></br>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-center">


        <div class="card px-5 py-5">
            <div class="card-body">
                <h2 class="card-title text-center my-3">Ajouter des candidats</h2>
                <form class="mt-5 needs-validation" method="post" action="/tp-vote/add_candidate" novalidate>
                    <div class="row mb-3">
                        <label for="inputCandidate_name " class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <input type="text" name="candidate_name" class="form-control" id="inputCandidate_name " required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputCandidate_party " class="col-sm-3 col-form-label">Parti</label>
                        <div class="col-sm-9">
                            <input type="text" name="candidate_party" class="form-control" id="inputCandidate_party" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>

            </div>
        </div>


    </div>
</section>