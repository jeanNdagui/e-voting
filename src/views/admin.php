<section class="admin__login container pt-5">

    <?php if (isset($data["erreurs"])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php foreach ($data["erreurs"] as $value) : ?>
                <?= $value; ?></br>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-center">

        <div class="card px-5 py-5">
            <div class="card-body">
                <h2 class="card-title text-center my-3">Se Connecter</h2>
                <form class="mt-5 needs-validation" method="post" action="/tp-vote/admin" novalidate>
                    <div class="row mb-3">
                        <label for="inputLogin" class="col-sm-3 col-form-label">Login</label>
                        <div class="col-sm-9">
                            <input type="text" name="login" class="form-control" id="inputLogin" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="inputPassword" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>

            </div>
        </div>

    </div>
</section>