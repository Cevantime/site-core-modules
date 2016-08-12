<?php

if (!file_exists('./uploads')) {
	mkdir('./uploads');
}
if (!file_exists('./uploads/posts')) {
	mkdir('./uploads/filebrowser');
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./uploads'));

foreach($iterator as $item) {
    chmod($item, 0777);
}