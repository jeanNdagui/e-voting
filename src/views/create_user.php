<section class="admin__login container pt-5">
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
                <h2 class="card-title text-center my-3">S'enregistrer</h2>
                <form class="mt-5 needs-validation" method="post" action="/tp-vote/create_user" novalidate>
                    <div class="row mb-3">
                        <label for="inputUsername" class="col-sm-3 col-form-label">username</label>
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" id="inputUsername" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputMobile" class="col-sm-3 col-form-label">mobile</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" name="contact_no" class="form-control" id="inputMobile" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputCni" class="col-sm-3 col-form-label">cni</label>
                        <div class="col-sm-9">
                            <input type="number" name="cni" min="0" class="form-control" id="inputCni" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="inputPassword" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">S'enregistrer</button>
                </form>

            </div>
        </div>


    </div>
</section>