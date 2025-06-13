package com.example.projectkape

import android.content.Intent
import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.activity.enableEdgeToEdge
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.firestore.FirebaseFirestore

class SignUp : AppCompatActivity() {

    private lateinit var firestore: FirebaseFirestore
    private lateinit var auth: FirebaseAuth

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_signup)

        firestore = FirebaseFirestore.getInstance()
        auth = FirebaseAuth.getInstance()

        val tvSignIn = findViewById<TextView>(R.id.tvSignIn)
        val etName = findViewById<EditText>(R.id.etName)
        val etNumber = findViewById<EditText>(R.id.etNumber)
        val etEmail = findViewById<EditText>(R.id.etEmail)
        val etAddress = findViewById<EditText>(R.id.etAddress)
        val etPassword = findViewById<EditText>(R.id.passwordInput)
        val btnRegister = findViewById<Button>(R.id.btnSignup)

        tvSignIn.setOnClickListener {
            startActivity(Intent(this, MainActivity::class.java))
        }

        btnRegister.setOnClickListener {
            val name = etName.text.toString().trim()
            val email = etEmail.text.toString().trim()
            val number = etNumber.text.toString().trim()
            val address = etAddress.text.toString().trim()
            val password = etPassword.text.toString()

            if (name.isEmpty() || email.isEmpty() || number.isEmpty() || address.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Please fill in all fields", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            // Create user using Firebase Authentication
            auth.createUserWithEmailAndPassword(email, password)
                .addOnCompleteListener { task ->
                    if (task.isSuccessful) {
                        val userId = auth.currentUser!!.uid

                        val user = hashMapOf(
                            "name" to name,
                            "email" to email,
                            "number" to number,
                            "address" to address
                        )

                        firestore.collection("users")
                            .document(userId)
                            .set(user)
                            .addOnSuccessListener {
                                Toast.makeText(this, "User Registered!", Toast.LENGTH_SHORT).show()
                                etName.text.clear()
                                etEmail.text.clear()
                                etNumber.text.clear()
                                etAddress.text.clear()
                                etPassword.text.clear()
                            }
                            .addOnFailureListener { e ->
                                Toast.makeText(this, "Registration failed: ${e.message}", Toast.LENGTH_SHORT).show()
                            }
                    } else {
                        Toast.makeText(this, "Authentication failed: ${task.exception?.message}", Toast.LENGTH_SHORT).show()
                    }
                }
        }
    }
}
