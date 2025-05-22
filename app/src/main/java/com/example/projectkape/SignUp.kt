package com.example.projectkape

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.activity.enableEdgeToEdge
import com.example.projectkape.R.*

class SignUp : AppCompatActivity() {

    private lateinit var dbHelper: DatabaseHelper

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(layout.activity_signup)


        val tvSignIn = findViewById<TextView>(R.id.tvSignIn)
        tvSignIn.setOnClickListener {
            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent)
        }

        dbHelper = DatabaseHelper(this)

        val etName = findViewById<EditText>(id.etName)
        val etNumber = findViewById<EditText>(id.etNumber)
        val etEmail = findViewById<EditText>(id.etEmail)
        val etAddress = findViewById<EditText>(id.etAddress)
        val etPassword = findViewById<EditText>(id.passwordInput)
        val btnRegister = findViewById<Button>(id.btnSignup)

        btnRegister.setOnClickListener {
            val name = etName.text.toString()
            val email = etEmail.text.toString()
            val number = etNumber.text.toString()
            val address = etAddress.text.toString()
            val password = etPassword.text.toString()

            val success = dbHelper.insertUser(name, email, number, address, password)

            if (success) {
                Toast.makeText(this, "User Registered!", Toast.LENGTH_SHORT).show()
                etName.text.clear()
                etEmail.text.clear()
                etNumber.text.clear()
                etAddress.text.clear()
                etPassword.text.clear()
            } else {
                Toast.makeText(this, "Registration Failed", Toast.LENGTH_SHORT).show()
            }
        }
    }
}
