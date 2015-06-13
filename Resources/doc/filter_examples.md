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
 9  | Ivan      | Idol
 10 | Jane      | Johnson

###Genre

 id | name
----|------------------
 1  | alternative
 2  | blues
 3  | classical
 4  | country
 5  | dance
 6  | electronic
 7  | hip-hop/rap
 8  | holiday
 9  | inspirational
 10 | jazz
 11 | latin
 12 | pop
 13 | r&b/soul
 14 | rock
 15 | singer/songwriter
 16 | vocal
 17 | world

###Band

 id | name
----|-----------------------
 1  | Electric End Users
 2  | Courageous Companies
 3  | Awesome Agencies
 4  | Dependable Departments
 5  | Fantastic Forms
 6  | Beautiful Billings

###BandGenres

 band_id | genre_id
---------|---------
 1       | 7
 2       | 12
 2       | 9
 3       | 5
 3       | 15
 3       | 8
 4       | 12
 4       | 14
 4       | 6
 4       | 10
 4       | 7
 5       | 10
 5       | 16
 5       | 1
 5       | 7
 5       | 3
 5       | 9
 5       | 14
 6       | 13
 6       | 4
 6       | 10
 6       | 6
 6       | 16
 6       | 7
 6       | 12
 6       | 1
 6       | 9

###Instrument

 id | name
----|------------
 1  | guitar
 2  | bass guitar
 3  | drums
 4  | vocal
 5  | keytar
 
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

### FilterCategory

 id | name
----|-------------
 1  | Talent Agent

### Filter

 id | filter_category_id | name                        | solvent
----|--------------------|-----------------------------|---------
 1  | 1                  | Electric End Users band     | band = 1
 2  | 1                  | Courageous Companies band   | band = 2
 3  | 1                  | Awesome Agencies band       | band = 3
 4  | 1                  | Dependable Departments band | band = 4
 5  | 1                  | Fantastic Forms band        | band = 5
 6  | 1                  | Beautiful Billings band     | band = 6

### UserFilter

 id | user_id | filter_id
----|---------|----------
 1  | 9       | 1
 1  | 9       | 2
 1  | 9       | 5
 1  | 9       | 6
 1  | 10      | 3
 1  | 10      | 4
