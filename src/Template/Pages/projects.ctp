<h2>Projects</h2>
My little projects - mainly for testing purposes.<br/>
Some might even be useful. If you are interested, drop me a line.<br />
Maybe you find some errors, program some enhancements or just tell me what could be added.

<br />
<h2>Status: Completed (Beta)</h2>
<ul>
<li>
<b>Role Application - Users can apply for "admin", "moderator" roles etc.</b>
<br />
Extends the Cake core role system (With Auth/Acl). In this special case it uses AuthExt Component by Franck (with a small modification)
for the possibility to have multiple roles per user.</br>
But it would work with any "single" role system as well - as it is independant from the live "roles" table. The "approve method" has to be altered then, though.
Details <?php echo $this->Html->link('here', ['modul-role-application'], ['title' => 'Role Application Modul']);?>.
</li>
</ul>



<br />
<h2>Status: In development</h2>
<ul>

<li>
<b>Fuel Consumption - keeping track of fuel costs / milage / development</b>
<br />
Individually for each car observed. Calculates the missing value out of the other 2 values given.<br />
<?php echo $this->Html->link('See it in action', ['controller' => 'fuel_consumptions'], ['title' => 'Here is a working example of this project']);?>
</li>

<li>
<b>Voting System</b>
</li>
</ul>





<br />
<h2>Status: Well - anyone some spare time? :)</h2>
<ul>

<li>
<b>Poll System</b>
<br />
Should be able to handle unlimited options - beeing able to use it in a project or a community page would be nice as well.
<br/>
As a addon, it could function as an "election" system as well - like for admins/mods: Everybody can apply - and is added as an "option".
Now everybody can vote 1 time and finally the top "x" is elected as president - or at least as new mod for a site or something.<br>
Besides all the "normal" poll features: "poll active/inactive, "limiting to a period of time or certain user groups", "avoiding double votes of a user" etc
</li>

<li>
<b>Messaging System</b>
<br />
Maybe with friend/block list - multiple addresses - flood protection - email notification - etc.
</li>


<li>
... to be continued
</li>

</ul>

<br />
<?php echo $this->Html->link('Send me your idea', ['controller' => 'contact', 'subject' => 'Project idea'], ['title' => 'To the contact form']);