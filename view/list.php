<section class="list">
    <div class="center panel panel-default">
        <div class="panel-heading">
            <h2>Lista producentów</h2>
            <h6><a href="http://<?=$_SERVER['HTTP_HOST'].LOCAL_URI?>" title="Strona główna">Strona główna</a></h6>
        </div>
        <div class="processInfo <?=isset($errors['apiErrors']) ? 'failed' : ''?>">
            <?if(!$success):?>
                <?=isset($errors['apiErrors']) ? $errors['apiErrors'] : ''?>
            <?endif?>
        </div>
        <div class="panel-body">
            <?if(isset($rows) && count($rows) > 0):?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Adres strony WWW</th>
                            <th>Logo</th>
                            <th>Zamówienie</th>
                            <th>ID zasobu</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?foreach($rows as $row):?>
                        <tr>
                            <td><?=$row['id']?></td>
                            <td><?=\Isystems\Helpers\CustomHelper::clearString(\Isystems\Helpers\CustomHelper::cutString( $row['name'], 1, 20))?></td>
                            <td>
                                <?if(!empty($row['page'])):?>
                                    <a href="<?=\Isystems\Helpers\CustomHelper::prepUrl($row['page']);?>" target="_blank" title="<?=\Isystems\Helpers\CustomHelper::cutString($row['name']);?>"><?=\Isystems\Helpers\CustomHelper::cutString($row['name']);?></a>
                                <?else:?>
                                    ---
                                <?endif?>
                            </td>
                            <td>
                                <?if(!empty($row['logo'])):?>
                                    <?if (strncmp(parse_url($row['logo'])['scheme'], 'http', 4) === 0): ?>
                                        <?if(end(explode('.', $row['logo'])) != 'png'):?>
                                            <img src="<?=$row['logo']?>" alt="Brak" style="max-width: 100px;max-height: 100px;"/>
                                        <?endif;?>
                                    <?else:?>
                                        <?=$row['logo'];?>
                                    <?endif;?>
                                <?else:?>
                                    ---
                                <?endif?>
                            </td>
                            <td><?=$row['priority']?></td>
                            <td><?=$row['ordering']?></td>
                            <td><?=$row['source_id'] ? $row['source_id'] : '---'?></td>
                        </tr>
                    <?endforeach?>
                    </tbody>
                </table>
            <?else:?>
                <p>Brak producentów</p>
            <?endif?>
        </div>
    </div>
</section>