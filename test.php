<?php
if(fsockopen("jesin.tk",28000))
{
print "I can see port 28000";
}
else
{
print "I cannot see port 28000";
}
?>
