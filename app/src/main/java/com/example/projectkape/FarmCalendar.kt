package com.example.projectkape

import android.app.AlertDialog
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.widget.EditText
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.applandeo.materialcalendarview.CalendarDay
import com.applandeo.materialcalendarview.CalendarView
import com.applandeo.materialcalendarview.listeners.OnCalendarDayClickListener
import com.example.projectkape.R
import com.google.android.material.floatingactionbutton.FloatingActionButton
import com.google.firebase.firestore.FirebaseFirestore
import java.text.SimpleDateFormat
import java.util.*

class FarmCalendar : AppCompatActivity() {

    private lateinit var db: FirebaseFirestore
    private lateinit var calendarView: CalendarView
    private val eventMap = mutableMapOf<String, MutableList<Map<String, Any>>>()
    private val sdfStorage = SimpleDateFormat("MMMM dd, yyyy", Locale.getDefault())
    private val sdfInternal = SimpleDateFormat("yyyy-MM-dd", Locale.getDefault())

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_farm_calendar)

        db = FirebaseFirestore.getInstance()
        calendarView = findViewById(R.id.calendarView)

        val fab: FloatingActionButton = findViewById(R.id.addEventButton)
        fab.setOnClickListener {
            showAddEventDialog()
        }

        loadEventsFromFirestore()

        calendarView.setOnCalendarDayClickListener(object : OnCalendarDayClickListener {
            override fun onClick(calendarDay: CalendarDay) {
                val calendar = calendarDay.calendar
                val selectedDate = sdfInternal.format(calendar.time)

                if (eventMap.containsKey(selectedDate)) {
                    val eventList = eventMap[selectedDate] ?: return
                    val msg = eventList.joinToString("\n\n") {
                        "📌 ${it["title"]}\n🕒 ${it["time"]}\n📍 ${it["location"]}\n📝 ${it["notes"]}"
                    }
                    AlertDialog.Builder(this@FarmCalendar)
                        .setTitle("Events on ${sdfStorage.format(calendar.time)}")
                        .setMessage(msg)
                        .setPositiveButton("OK", null)
                        .show()
                } else {
                    Toast.makeText(
                        this@FarmCalendar,
                        "📭 No events on ${sdfStorage.format(calendar.time)}",
                        Toast.LENGTH_SHORT
                    ).show()
                }
            }
        })
    }

    private fun loadEventsFromFirestore() {
        db.collection("events")
            .get()
            .addOnSuccessListener { documents ->
                for (doc in documents) {
                    val dateStr = doc.getString("date")
                    try {
                        val parsedDate = sdfStorage.parse(dateStr ?: "") ?: continue
                        val internalDate = sdfInternal.format(parsedDate)

                        val event = mapOf(
                            "title" to (doc.getString("title") ?: ""),
                            "time" to (doc.getString("time") ?: ""),
                            "location" to (doc.getString("location") ?: ""),
                            "notes" to (doc.getString("notes") ?: "")
                        )
                        eventMap.getOrPut(internalDate) { mutableListOf() }.add(event)
                    } catch (e: Exception) {
                        Log.e("FarmCalendar", "Date parse error: $dateStr", e)
                    }
                }
            }
            .addOnFailureListener {
                Toast.makeText(this, "Failed to load events", Toast.LENGTH_SHORT).show()
            }
    }

    private fun showAddEventDialog() {
        val dialogView = LayoutInflater.from(this).inflate(R.layout.dialog_add_event, null)

        val eventTitle = dialogView.findViewById<EditText>(R.id.eventTitle)
        val eventTime = dialogView.findViewById<EditText>(R.id.eventTime)
        val eventDate = dialogView.findViewById<EditText>(R.id.eventDate)
        val eventType = dialogView.findViewById<EditText>(R.id.eventType)
        val eventLocation = dialogView.findViewById<EditText>(R.id.eventLocation)
        val eventNotes = dialogView.findViewById<EditText>(R.id.eventNotes)

        AlertDialog.Builder(this)
            .setView(dialogView)
            .setTitle("Add New Event")
            .setPositiveButton("Save") { _, _ ->
                val title = eventTitle.text.toString().trim()
                val time = eventTime.text.toString().trim()
                val date = eventDate.text.toString().trim()
                val type = eventType.text.toString().trim()
                val location = eventLocation.text.toString().trim()
                val notes = eventNotes.text.toString().trim()

                if (title.isNotEmpty() && date.isNotEmpty()) {
                    val event = hashMapOf(
                        "title" to title,
                        "time" to time,
                        "date" to date,
                        "type" to type,
                        "location" to location,
                        "notes" to notes,
                        "timestamp" to System.currentTimeMillis()
                    )

                    db.collection("events")
                        .add(event)
                        .addOnSuccessListener {
                            Toast.makeText(this, "✅ Event '$title' added", Toast.LENGTH_SHORT).show()
                            try {
                                val parsedDate = sdfStorage.parse(date)
                                parsedDate?.let {
                                    val internalDate = sdfInternal.format(it)
                                    eventMap.getOrPut(internalDate) { mutableListOf() }.add(event)
                                }
                            } catch (_: Exception) {
                            }
                        }
                        .addOnFailureListener {
                            Toast.makeText(this, "❌ Failed to add event", Toast.LENGTH_SHORT).show()
                        }
                } else {
                    Toast.makeText(this, "❗ Title and Date are required", Toast.LENGTH_SHORT).show()
                }
            }
            .setNegativeButton("Cancel", null)
            .create()
            .show()
    }
}
