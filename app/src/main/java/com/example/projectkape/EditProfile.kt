package com.example.projectkape

import android.app.AlertDialog
import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Build
import android.os.Bundle
import android.provider.OpenableColumns
import android.widget.*
import androidx.activity.result.contract.ActivityResultContracts
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AppCompatActivity
import java.io.File
import java.io.FileOutputStream
import java.io.InputStream

class EditProfile : AppCompatActivity() {

    private lateinit var profilePhoto: ImageView
    private lateinit var nameTextView: TextView
    private lateinit var addressTextView: TextView
    private lateinit var editName: TextView
    private lateinit var editAddress: TextView
    private lateinit var saveButton: Button
    private lateinit var profilePicUpload: TextView
    private var selectedImageUri: Uri? = null

    @RequiresApi(Build.VERSION_CODES.O)
    private val pickImageLauncher = registerForActivityResult(ActivityResultContracts.GetContent()) { uri: Uri? ->
        uri?.let {
            val savedUri = saveImageToInternalStorage(it)
            if (savedUri != null) {
                selectedImageUri = savedUri
                profilePhoto.setImageURI(savedUri)
            } else {
                Toast.makeText(this, "Failed to save image", Toast.LENGTH_SHORT).show()
            }
        }
    }

    @RequiresApi(Build.VERSION_CODES.O)
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_edit_profile)

        profilePhoto = findViewById(R.id.profilePic)
        nameTextView = findViewById(R.id.fullName)
        addressTextView = findViewById(R.id.fullAddress)
        editName = findViewById(R.id.editName)
        editAddress = findViewById(R.id.editAddress)
        saveButton = findViewById(R.id.saveButton)
        profilePicUpload = findViewById(R.id.profilePicUpload) // Your "I-edit" TextView

        loadSavedProfile()

        // Click on image to pick a new photo
        profilePhoto.setOnClickListener {
            pickImageLauncher.launch("image/*")
        }

        // Click on "I-edit" to pick a new photo
        profilePicUpload.setOnClickListener {
            pickImageLauncher.launch("image/*")
        }

        editName.setOnClickListener {
            showEditDialog("Edit Name", nameTextView)
        }

        editAddress.setOnClickListener {
            showEditDialog("Edit Address", addressTextView)
        }

        saveButton.setOnClickListener {
            saveProfile()
        }
    }

    private fun showEditDialog(title: String, targetView: TextView) {
        val input = EditText(this)
        input.setText(targetView.text.toString())

        AlertDialog.Builder(this)
            .setTitle(title)
            .setView(input)
            .setPositiveButton("OK") { _, _ ->
                targetView.text = input.text.toString()
            }
            .setNegativeButton("Cancel", null)
            .show()
    }

    @RequiresApi(Build.VERSION_CODES.O)
    private fun saveImageToInternalStorage(uri: Uri): Uri? {
        return try {
            val fileName = getFileName(uri) ?: "profile_image.jpg"
            val file = File(filesDir, fileName)
            val inputStream: InputStream? = contentResolver.openInputStream(uri)
            val outputStream = FileOutputStream(file)

            inputStream?.use { input ->
                outputStream.use { output ->
                    input.copyTo(output)
                }
            }

            Uri.fromFile(file)
        } catch (e: Exception) {
            e.printStackTrace()
            null
        }
    }

    @RequiresApi(Build.VERSION_CODES.O)
    private fun getFileName(uri: Uri): String? {
        var name: String? = null
        val cursor = contentResolver.query(uri, null, null, null, null)
        cursor?.use {
            if (it.moveToFirst()) {
                val index = it.getColumnIndex(OpenableColumns.DISPLAY_NAME)
                if (index != -1) {
                    name = it.getString(index)
                } else {
                    name = "profile_image_${System.currentTimeMillis()}.jpg"
                }
            }
        }
        return name
    }

    private fun saveProfile() {
        val name = nameTextView.text.toString()
        val address = addressTextView.text.toString()
        val imageUriString = selectedImageUri?.toString()

        val sharedPreferences = getSharedPreferences("ProfileData", Context.MODE_PRIVATE)
        with(sharedPreferences.edit()) {
            putString("name", name)
            putString("address", address)
            putString("imageUri", imageUriString)
            apply()
        }

        Toast.makeText(this, "Profile saved", Toast.LENGTH_SHORT).show()
    }

    private fun loadSavedProfile() {
        val sharedPreferences = getSharedPreferences("ProfileData", Context.MODE_PRIVATE)
        nameTextView.text = sharedPreferences.getString("name", "Full Name")
        addressTextView.text = sharedPreferences.getString("address", "Exact Address")

        val imageUriString = sharedPreferences.getString("imageUri", null)
        imageUriString?.let {
            val uri = Uri.parse(it)
            profilePhoto.setImageURI(uri)
            selectedImageUri = uri
        }
    }
}
