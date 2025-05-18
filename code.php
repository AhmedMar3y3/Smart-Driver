<?php 
/*
So we have this feature for plates but we need to add code to the plates table
so I made a new table for plate codes
and I added a foreign key to the plates table

so each emirate has multiple plate codes like 
Dubai has from A to Z and AA,BB,CC,DD
Abu Dhabi has from 1 to 21 and 50 
Sharjah has from 1 to 4
rest of the emirates have from A to Z

so we need to handle that each emirate gets only the plate codes that are available for it
and also we need to make a seeder for the plate codes and an endpoint to return the codes based on the emirate_id
and also the plates that are classic plates should not have plate codes and the classic is available for Dubai and Abu Dhabi and Sharjah only
*/