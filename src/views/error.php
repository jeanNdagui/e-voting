<section class="admin__login container pt-5">
    <?php if (isset($data["erreurs"])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $data["erreurs"]; ?>
        </div>
    <?php endif ?>
</section>