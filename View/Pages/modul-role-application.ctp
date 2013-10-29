<h1>MODUL: Role Application</h1>
Users can apply for "admin", "moderator" roles etc.

<br /><br />
Status: Completed (Beta)

<h2>Overview</h2>
Extends the Cake core role system (With Auth/Acl). In this special case it uses AuthExt Component by Franck (with a small modification)
for the possibility to have multiple roles per user.</br>
But it would work with any "single" role system as well - as it is independant from the live "roles" table. The "approve method" has to be altered then, though.


<h2>Details</h2>
The Main aspects are:

<ul>

<li>
Extra toggle field in "roles" controller: "applyable" (TINYINT(1) - 0/1)<br>
Usually not all roles are for users to apply for (e.g. "Guest", "Superadmin", "TestUser" etc)
</li>

<li>
A user can apply only for roles that he does not already have.<br />
Includes a check if application already processed (= role is already set) before the save() is triggered - to prevent that this is done twice - and the user gets a role twice.
</li>

<li>
After applying, if the user wants to apply again, all pending "roles" (as well as the roles he already has) are not shown anymore either. Prevents "double" applications.
</li>

<li>
Full logging history. Including the "admin userid" that checked it. Not deletable by anybody except the "superadmin" for example. Users have their own history not beeing able to see "admin only comments" which
can be used for admin notes. They will see the comment/reasoning for a disapproved application though. As they should know why their whish for applying to a certain role was denyed.
</li>

<li>
Optional: Nobody can approve his own applications. Prevents missusage under everybody having access to the "check" action.
</li>

<li>
Optional: After processing an application, it cannot be changed anymore by anyone. The other case would be, that the application could be dissapproved by one admin, and the next admin then "revalidates"
it and then approves it (the other way is not implemented - the role has to be deleted "manually" in the roles controller). In this case a second log entry will be created, showing which admin did what.
With the first case active, the user would have to re-apply.
</li>

</ul>







<br />
<?php echo $this->Html->link('Send me your ideas for improvement', array('controller'=>'contact','subject'=>'Idea for Improvement'), array('title'=>'To the contact form'));