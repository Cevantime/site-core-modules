<?php

if (!file_exists('./uploads')) {
	mkdir('./uploads');
}
if (!file_exists('./uploads/slides')) {
	mkdir('./uploads/slides');
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./uploads'));

foreach($iterator as $item) {
    chmod($item, 0777);
}