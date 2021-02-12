<?php
symlink('../storage/app/public/', 'storage'); 
$miaou = readlink('storage');
echo $miaou;