<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <col width="15%">
    <col width="18%">
    <col width="12%">
    <col width="8%">
    <col width="17%">
    <thead>
        <tr>
            <th>NIP</th>
            <th>NAMA</th>
            <th>PANGKAT</th>
            <th>GOLONGAN</th>
            <th>JABATAN</th>
            <th>TANGGAL LAHIR</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($list as $li) {
            echo "<tr>
                            <td>" . $li->NIP . "</td>
                            <td>" . $li->NAMA . "</td>
                            <td>" . $li->PANGKAT . " </td>
                            <td>" . $li->GOLONGAN . "</td>
                            <td>" . $li->JABATAN . "</td>
                            <td>" . $li->TANGGALLAHIR . "</td>
                            <td><a href=\"#\" class=\"d-none d-sm-inline-block btn btn-sm btn-info\"><i class=\"fas fa-sm fa-edit\"></i> Edit </a>
                            </tr>";
        }
        ?>

    </tbody>
</table>