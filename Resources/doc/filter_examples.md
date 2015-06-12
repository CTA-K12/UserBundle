##Filter Examples

For these examples, the following tables will be assumed

###Users

 id | firstName | lastName
----|-----------|---------
 1  | Helen     | Hardy
 2  | Greg      | Gable
 3  | Dan       | Doyle
 4  | Bob       | Bell
 5  | Alice     | Adams
 6  | Eve       | Evans
 7  | Fred      | Flint
 8  | Carol     | Carver

###Instrument

 id | name
----|------------
 1  | guitar
 2  | bass guitar
 3  | drums
 4  | vocal
 5  | keytar
 
###Band

 id | name
----|---------------------
 1  | Electric End Users
 2  | Courageous Companies
 3  | Awesome Agencies
 4  | Dependable Districts
 5  | Fantastic Forms
 6  | Beautiful Billers

###BandMember

 id | band_id | user_id | instrument_id
----|---------|---------|--------------
 1  | 1       | 5       | 3
 2  | 1       | 4       | 1
 3  | 1       | 7       | 4
 4  | 2       | 3       | 1
 5  | 2       | 1       | 4
 6  | 3       | 5       | 4
 7  | 4       | 2       | 4
 8  | 4       | 3       | 1
 9  | 4       | 6       | 3
 10 | 5       | 8       | 1
 11 | 5       | 3       | 2
 12 | 5       | 5       | 3
 13 | 6       | 1       | 4
 14 | 6       | 2       | 4
 15 | 6       | 5       | 4
 16 | 6       | 7       | 4
