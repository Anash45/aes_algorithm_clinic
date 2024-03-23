<aside>
    <ul class="aside-list">
        <?php
        if (isAdmin()) {
            ?>
            <li class="nav-title">Doctors</li>
            <li>
                <a href="add_doctor.php" class="nav-link">Add Doctor</a>
            </li>
            <li>
                <a href="doctors.php" class="nav-link">View Doctors</a>
            </li>
            <?php
        }
        ?>
        <li class="nav-title">Patients</li>
        <li>
            <a href="add_patient.php" class="nav-link">Add Patient</a>
        </li>
        <li>
            <a href="patients.php" class="nav-link">View patients</a>
        </li>
        <li class="nav-title">Files</li>
        <li>
            <a href="add_file.php" class="nav-link">Add file</a>
        </li>
        <li>
            <a href="files.php" class="nav-link">View files</a>
        </li>
    </ul>
</aside>