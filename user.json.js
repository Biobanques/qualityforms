/* 
 * command to create the admin user for this db.
 * only available since mongo 2.6
 * add this user using the db qualityformsdb
 * 
 * use qualityformsdb;
 */



db.createUser(
{ user: "qfuseradmin",
  pwd: "bbanques2015",
  roles: [
    {role:"userAdmin",db:"qualityformsdb"}
  ]
}
        )

db.grantRolesToUser(
  "qfuseradmin",
  [
    {
      role: "readWrite", db: "qualityformsdb"
    },
  ]
)
db.grantRolesToUser(
  "qfuseradmin",
  [
    {
      role: "dbOwner", db: "qualityformsdb"
    },
  ]
)