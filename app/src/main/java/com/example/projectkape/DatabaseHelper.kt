package com.example.projectkape

import android.content.ContentValues
import android.content.Context
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class DatabaseHelper(context: Context) :
    SQLiteOpenHelper(context, DATABASE_NAME, null, DATABASE_VERSION) {

    companion object {
        private const val DATABASE_NAME = "UserDB.db"
        private const val DATABASE_VERSION = 2

        const val TABLE_NAME   = "users"
        const val COL_ID       = "id"
        const val COL_NAME     = "name"
        const val COL_EMAIL    = "email"
        const val COL_ADDRESS  = "address"
        const val COL_NUMBER   = "number"
        const val COL_PASSWORD = "password"
    }

    override fun onCreate(db: SQLiteDatabase) {
        val createTable = """
        CREATE TABLE $TABLE_NAME (
            $COL_ID INTEGER PRIMARY KEY AUTOINCREMENT,
            $COL_NAME TEXT,
            $COL_EMAIL TEXT,
            $COL_ADDRESS TEXT,
            $COL_NUMBER TEXT,
            $COL_PASSWORD TEXT
        )
        """.trimIndent()

        db.execSQL(createTable)
    }

    override fun onUpgrade(db: SQLiteDatabase, oldVersion: Int, newVersion: Int) {
        // Drop existing table
        db.execSQL("DROP TABLE IF EXISTS $TABLE_NAME")
        // Recreate table with updated schema including email column
        onCreate(db)
    }


    fun insertUser(name: String, email: String, number: String, address: String, password: String): Boolean {
        val db = writableDatabase
        val values = ContentValues()
        values.put(COL_NAME, name)
        values.put(COL_EMAIL, email)
        values.put(COL_NUMBER, number)
        values.put(COL_ADDRESS, address)
        values.put(COL_PASSWORD, password)

        val result = db.insert(TABLE_NAME, null, values)
        return result != -1L
    }

    fun checkUser(email:String, password:String): Boolean {
        val db = readableDatabase
        val c = db.rawQuery(
            "SELECT $COL_ID FROM $TABLE_NAME WHERE $COL_EMAIL=? AND $COL_PASSWORD=? LIMIT 1",
            arrayOf(email, password)
        )
        val found = c.moveToFirst()
        c.close()
        db.close()
        return found
    }
}
