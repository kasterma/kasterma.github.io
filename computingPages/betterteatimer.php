<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>
        A Better Tea Timer
</title>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="Bart Kastermans' Better Tea Timer"></meta>
<meta name="keywords" content="Bart, Kastermans, Bart Kastermans,
                               arduino, tea timer"></meta>

<link rel="stylesheet" type="text/css" href="bkstyle.php"></link>

<?php include ("menudf.incl"); ?>

<?php writemenufunctions ($onbartk); 
      echo "\n";
      writemenufunctions ($elsewhere); ?>

<script type="text/javascript" src="synthl/shCore.js"></script>
<script type="text/javascript" src="synthl/shBrushCpp.js"></script>
<link rel="stylesheet" type="text/css" href="synthl/shCore.css"></link>
<link rel="stylesheet" type="text/css"
      href="synthl/shThemeDefault.css" ></link>

</head>

<body>

<?php $active = "teatimer"; include ('menu.php'); ?>

 <div class="content_ep">

     <h1 align="center">
       A Better Tea Timer
     </h1>
  
<p>
  If you follow me on twitter you have noticed that I have been upset
  with my tea making skills at times.  Mostly that is I'll start
  making some tea, start it steeping, and then only remember it a long
  time later.  Essentially I drink over-steeped tea 9 out of every 10
  times.  I have tried timers, and I'll just forget to set them.  So
  here is the better tea timer (the "user manual" is at the end of the
  post).
</p>

<center>
<a href="BTTimages/BTTpic.jpg">
  <img src="BTTimages/BTTpic-small.jpg"
       alt="Picture of BTT"
       title="The Better Tea Timer"
       width="300"
       height="240" />
</a>
</center>

<p>
  This is built around an <a href="http://arduino.cc/">arduino</a>.
  First the box was built with the following design (the holes to be
  drilled are not shown here, I rather improvised these with a
  borrowed---and not to sharp---drill).
</p>

<center>
<a href="BTTimages/boxdesign.png">
  <img src="BTTimages/boxdesign-small.png"
       alt="BTT box design"
       title="Design of the box."
       width="212"
       height="300" />
</a>
</center>

<p>
  The schematic for the electronics is as follows (I drew this after
  the fact, so no guarantees).  It is really rather simple.
</p>

<center>
<a href="BTTimages/btt-diagram.png">
  <img src="BTTimages/btt-diagram-small.png?"
       alt="BTT diagram"
       title="Circuit diagram."
       width="300"
       height="225" />
</a>
</center>

<p>
  The arduino sketch is as follows (all the serial communication was
  only of use during writing and testing of the sketch);
</p>

<pre class="brush: c;">
/* BTT - Better Tea Timer 0.1
 *
 * Bart Kastermans, www.bartk.nl
 */
 
int redLED = 2;      // pins for the leds
int yellowLED = 3;
int greenLED = 4;
int buzzer = 5;      // pin for the buzzer
int input1 = 0;      // read pin for one of the pots
int val1 = 0;        // variable to store value read from input1
int input2 = 1;      // same for second pot
int val2 = 0;
int wsensor = 2;     // read pin for weight sensor
int val_wsensor = 0; // variable to store its value in
int count = 0;       // counter for estimating times
int TEATIME = 180;   // hardcoded steep time, approx 2 min
int SILENCE = 240;   // if away, the buzzer should not keep going

void setup (void)
{
  pinMode (redLED, OUTPUT);      // setup the output pins (LEDs and
buzzer)
  pinMode (yellowLED, OUTPUT);
  pinMode (greenLED, OUTPUT);
  pinMode (buzzer, OUTPUT);
  Serial.begin(9600);            //  setup serial, for printing debug
info
}

void flashled (int led)
{
  digitalWrite (led, HIGH);
  delay (300);
  digitalWrite (led, LOW);
};

void buzz (int buzzer)
{
  digitalWrite (buzzer, HIGH);
  delay (200);  // shorter times do not come out well with this buzzer
  digitalWrite (buzzer, LOW);
}

void loop (void)
{
  val1 = analogRead (input1);    // get the sensor values
  val2 = analogRead (input2);
  val_wsensor = analogRead (wsensor);

  if (val_wsensor &lt; val1)  // empty cup detected
  {
    flashled (greenLED);
    Serial.println ("empty there");
  };
    
  if (val_wsensor &lt; val2)  // full cup (with hot water) detected
  {
    flashled (yellowLED);
    count += 1;
    Serial.println ("water there");
    Serial.println (count);
  }
  else
  {
    count = 0;
  };
  
  if (count &gt;= TEATIME)  // tea is ready
  {
    flashled (redLED);
    Serial.println ("tea done");
    if (count % 10 == 0 &amp;&amp; count &lt; SILENCE)  
      // only buzz every 10 times and for a bounded amount of time
      buzz (buzzer);
  }

  Serial.println ("w_sensor");   // for help with debugging
  Serial.println (val_wsensor);
  Serial.println ("val1");
  Serial.println (val1);
  Serial.println ("val2");
  Serial.println (val2);
}
</pre>

<script type="text/javascript">
     SyntaxHighlighter.all()
</script>

Finished it looks like this:

<center>
<a href="BTTimages/BTTopen.jpg">
  <img src="BTTimages/BTTopen-small.jpg" 
       alt="BTT open" 
       title="Open Better Tea Timer."  
       width="300" 
       height="297" />
</a>
</center>

<p>
  To use, first adjust pot1 so that the green led starts flashing when
  you put on the empty cup, then adjust pot2 so that the yellow led
  starts flashing when you put on the full cup. When you put on the
  full cup while steeping after about 2 minutes the red led starts
  flashing and the buzzer will buzz. The buzzer buzzes only a couple
  of times and shortly so as not to become irritating.
</p>

</div>

<?php include ('../footer.php'); ?>

</body>

</html>

