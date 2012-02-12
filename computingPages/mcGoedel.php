<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>
  Goedel numbering in Python
</title>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="Bart Kastermans' Better Tea Timer"></meta>
<meta name="keywords" content="Bart, Kastermans, Bart Kastermans,
                               Python, Goedel Numbering"></meta>

<link rel="stylesheet" type="text/css" href="bkstyle.php"></link>

<?php include ("menudf.incl"); ?>

<?php writemenufunctions ($onbartk); 
      echo "\n";
      writemenufunctions ($elsewhere); ?>

<script type="text/javascript" src="synthl/shCore.js"></script>
<script type="text/javascript" src="synthl/shBrushPython.js"></script>
<link rel="stylesheet" type="text/css" href="synthl/shCore.css"></link>
<link rel="stylesheet" type="text/css"
      href="synthl/shThemeDefault.css" ></link>

</head>

<body>

<?php $active = "mcGoedel"; include ('menu.php'); ?>

 <div class="content_ep">

     <h1 align="center">
       Goedel Numbering in Python.
     </h1>
  
<pre class="brush: python">
# goedel.py
#
# A Goedel numbering program for Math Circle talk
#
# Bart Kastermans, www.bartk.nl


table = '!\"#$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|} \n'

def location (symbol):
    """ return the index for symbol in table """
    return table.index (symbol)

def NoToString (no):
    """ return the string represented by no """
    ret_val = ""
    while no != 0:
        idx = no % len (table)
        ret_val += table [idx]
        no /= len (table)
    return ret_val

def StringToNo (string):
    """ return the number representing string """
    number = 0
    for idx in range (0, len (string)):
        number += location (string [idx]) * (len (table))**idx
    return number

print location ('h')
print location ('e')
print location ('l')
print location ('o')
print len (table)

hello_no = 70 * 1 + 67 * 94 + 74 * 94**2 + 74 * 94**3 + 77 * 94**4

print "hello:", NoToString (hello_no)

print "number:", StringToNo ('hello')

program = '#include &lt;stdio.h&gt;\n\nint main()\n{\n  printf("Hello world!");\n}'

progno = StringToNo(program)

print program

print "number for program", progno
</pre>

<script type="text/javascript">
     SyntaxHighlighter.all()
</script>

</div>

<?php include ('../footer.php'); ?>

</body>

</html>

