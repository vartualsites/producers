<section class="form">
    <div class="center panel panel-default">
        <div class="panel-heading">
            <h2>Dodaj producenta</h2>
            <h6><a href="http://<?=$_SERVER['HTTP_HOST'].LOCAL_URI?>" title="Strona główna">Strona główna</a></h6>
        </div>
        <div class="processInfo <?=isset($errors['apiErrors']) ? 'failed' : ($success ? 'success' : '')?>">
            <?if($success):?>
                Pomyślnie dodano producenta.
            <?else:?>
                <?=isset($errors['apiErrors']) ? $errors['apiErrors'] : ''?>
            <?endif?>
        </div>
        <form action="http://<?=$_SERVER['HTTP_HOST'].LOCAL_URI?>producers/add" method="post" class="panel-body" accept-charset="utf-8">
            <div>
                <label for="name">Nazwa:<spam class="req">*</spam> </label>
                <input type="text" name="name" id="name" value="<?=isset($fields['name'])?$fields['name']:''?>" class="form-control" placeholder="Nazwa" required="" autofocus="">
                <p class="formError"><?=isset($errors['name'])?$errors['name']:''?></p>
            </div>
            <div>
                <label for="site_url">Adres strony WWW: </label>
                <input type="url" name="site_url" id="site_url" value="<?=isset($fields['site_url'])?$fields['site_url']:''?>" class="form-control" placeholder="Adres strony WWW" autofocus="">
                <p class="formError"><?=isset($errors['site_url'])?$errors['site_url']:''?></p>
            </div>
            <div>
                <label for="logo_filename">Nazwa loga: </label>
                <input type="text" name="logo_filename" id="logo_filename" value="<?=isset($fields['logo_filename'])?$fields['logo_filename']:''?>" class="form-control" placeholder="Nazwa loga" autofocus="">
                <p class="formError"><?=isset($errors['logo_filename'])?$errors['logo_filename']:''?></p>
            </div>
            <div>
                <label for="ordering">Zamówienie:<spam class="req">*</spam> </label>
                <input type="text" name="ordering" id="ordering" value="<?=isset($fields['ordering'])?$fields['ordering']:''?>" class="form-control" placeholder="Zamówienie" required="" autofocus="">
                <p class="formError"><?=isset($errors['ordering'])?$errors['ordering']:''?></p>
            </div>
            <div>
                <label for="source_id">ID zasobu: </label>
                <input type="text" name="source_id" id="source_id" value="<?=isset($fields['source_id'])?$fields['source_id']:''?>" class="form-control" placeholder="ID zasobu" autofocus="">
                <p class="formError"><?=isset($errors['source_id'])?$errors['source_id']:''?></p>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Wyślij</button>
        </form>
    </div>
</section>