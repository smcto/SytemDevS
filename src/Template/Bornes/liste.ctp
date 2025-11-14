<table>
    <thead>
    <tr>
        <th>id</th>
        <th>Couleur</th>
        <th>Model</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($couleurPossibles as $couleur):; ?>
        <tr>
            <td><?= $couleur->id; ?></td>
            <td><?= $couleur->couleur; ?></td>
            <td><?= $couleur->model_borne_id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>