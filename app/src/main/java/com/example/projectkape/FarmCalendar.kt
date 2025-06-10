package com.example.projectkape

import android.app.AlertDialog
import android.os.Bundle
import android.view.LayoutInflater
import android.widget.EditText
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.google.android.material.floatingactionbutton.FloatingActionButton

class FarmCalendar : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_farm_calendar)

        val fab: FloatingActionButton = findViewById(R.id.addEventButton)
        fab.setOnClickListener {
            showAddEventDialog()
        }
    }

    private fun showAddEventDialog() {
        val dialogView = LayoutInflater.from(this).inflate(R.layout.dialog_add_event, null)
        val eventTitle = dialogView.findViewById<EditText>(R.id.eventTitle)
        val eventDescription = dialogView.findViewById<EditText>(R.id.eventNotes)

        val builder = AlertDialog.Builder(this)
            .setView(dialogView)
            .setTitle("Add New Event")
            .setPositiveButton("Save") { _, _ ->
                val title = eventTitle.text.toString().trim()
                val description = eventDescription.text.toString().trim()

                if (title.isNotEmpty()) {
                    // TODO: Save to Firebase or local storage
                    Toast.makeText(this, "✅ Event '$title' added", Toast.LENGTH_SHORT).show()
                } else {
                    Toast.makeText(this, "❗ Event title cannot be empty", Toast.LENGTH_SHORT).show()
                }
            }
            .setNegativeButton("Cancel", null)

        builder.create().show()
    }

}
