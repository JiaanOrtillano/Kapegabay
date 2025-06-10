package com.example.projectkape

import android.content.Intent
import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.activity.enableEdgeToEdge

class MainActivity : AppCompatActivity() {

    private lateinit var db: DatabaseHelper
    private lateinit var btnLogin: Button
    private lateinit var tvSignUp: TextView
    private lateinit var etEmail: EditText
    private lateinit var etPassword: EditText

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)

        // Initialize DB helper
        db = DatabaseHelper(this)

        // Bind UI components
        etEmail    = findViewById(R.id.etEmail)
        etPassword = findViewById(R.id.etPassword)
        btnLogin   = findViewById(R.id.login_bt)
        tvSignUp   = findViewById(R.id.btnSignup)

        // Sign Up navigation
        tvSignUp.setOnClickListener {
            startActivity(Intent(this, SignUp::class.java))
        }

        // Login action
        btnLogin.setOnClickListener {
            val email = etEmail.text.toString().trim()
            val password = etPassword.text.toString()

            if (email.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Please enter e-mail and password", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            if (db.checkUser(email, password)) {
                Toast.makeText(this, "Login successful!", Toast.LENGTH_SHORT).show()
                startActivity(Intent(this, Home::class.java))
                finish()
            } else {
                Toast.makeText(this, "Invalid credentials", Toast.LENGTH_SHORT).show()
            }
        }
    }
}
