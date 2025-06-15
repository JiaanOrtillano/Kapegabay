package com.example.projectkape

import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import com.google.firebase.firestore.FirebaseFirestore

class FormsActivity : AppCompatActivity() {

    private lateinit var db: FirebaseFirestore

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_forms) // make sure your XML is named activity_form.xml

        db = FirebaseFirestore.getInstance()
        val backButton = findViewById<ImageButton>(R.id.menuBack)
        val submitButton: Button = findViewById(R.id.submit_button)
        submitButton.setOnClickListener {
            submitForm()
        }
        backButton.setOnClickListener {
            finish()
        }
    }

    private fun submitForm() {
        val data = hashMapOf<String, Any?>()

        // --- Personal Info
        data["surname"] = findViewById<EditText>(R.id.surname).text.toString()
        data["first_name"] = findViewById<EditText>(R.id.first_name).text.toString()
        data["middle_name"] = findViewById<EditText>(R.id.middle_name).text.toString()
        data["extension_name"] = findViewById<EditText>(R.id.extension_name).text.toString()

        val sexGroup = findViewById<RadioGroup>(R.id.sex_group)
        data["sex"] = findViewById<RadioButton>(sexGroup.checkedRadioButtonId)?.text?.toString()

        // --- Address
        data["house_no"] = findViewById<EditText>(R.id.house_no).text.toString()
        data["street"] = findViewById<EditText>(R.id.street).text.toString()
        data["barangay"] = findViewById<EditText>(R.id.barangay).text.toString()
        data["municipality"] = findViewById<EditText>(R.id.municipality).text.toString()
        data["province"] = findViewById<EditText>(R.id.province).text.toString()
        data["region"] = findViewById<EditText>(R.id.region).text.toString()

        // --- Contact
        data["mobile"] = findViewById<EditText>(R.id.mobile).text.toString()
        data["landline"] = findViewById<EditText>(R.id.landline).text.toString()

        // --- Birth and Civil Info
        data["date_of_birth"] = findViewById<EditText>(R.id.date_of_birth).text.toString()
        data["place_of_birth"] = findViewById<EditText>(R.id.place_of_birth).text.toString()
        data["religion"] = findViewById<EditText>(R.id.religion).text.toString()

        val civilGroup = findViewById<RadioGroup>(R.id.civil_status)
        data["civil_status"] = findViewById<RadioButton>(civilGroup.checkedRadioButtonId)?.text?.toString()

        data["spouse_name"] = findViewById<EditText>(R.id.spouse_name).text.toString()
        data["mother_maiden"] = findViewById<EditText>(R.id.mother_maiden).text.toString()

        // --- Household
        data["household_head"] = findViewById<CheckBox>(R.id.household_head).isChecked
        data["household_members"] = findViewById<EditText>(R.id.household_members).text.toString()
        data["male_members"] = findViewById<EditText>(R.id.male_members).text.toString()
        data["female_members"] = findViewById<EditText>(R.id.female_members).text.toString()

        // --- Education and ID
        data["highest_education"] = findViewById<EditText>(R.id.highest_education).text.toString()
        data["pwd"] = findViewById<CheckBox>(R.id.pwd).isChecked
        data["beneficiary_4ps"] = findViewById<CheckBox>(R.id.beneficiary_4ps).isChecked
        data["indigenous"] = findViewById<CheckBox>(R.id.indigenous).isChecked
        data["government_id"] = findViewById<EditText>(R.id.government_id).text.toString()
        data["id_number"] = findViewById<EditText>(R.id.id_number).text.toString()
        data["farmer_org"] = findViewById<CheckBox>(R.id.farmer_org).isChecked

        // --- Emergency Contact
        data["notify_name"] = findViewById<EditText>(R.id.notify_name).text.toString()
        data["notify_contact"] = findViewById<EditText>(R.id.notify_contact).text.toString()

        // --- Farm Profile
        val livelihoodGroup = findViewById<RadioGroup>(R.id.livelihood_group)
        data["main_livelihood"] = findViewById<RadioButton>(livelihoodGroup.checkedRadioButtonId)?.text?.toString()

        data["farming_type"] = findViewById<EditText>(R.id.farming_type).text.toString()
        data["farming_kind"] = findViewById<EditText>(R.id.farming_kind).text.toString()
        data["fishing_type"] = findViewById<EditText>(R.id.fishing_type).text.toString()
        data["gross_income"] = findViewById<EditText>(R.id.gross_income).text.toString()

        // --- Firestore Submission
        db.collection("form_submissions")
            .add(data)
            .addOnSuccessListener {
                Toast.makeText(this, "Form submitted successfully!", Toast.LENGTH_LONG).show()
                finish()
            }
            .addOnFailureListener { e ->
                Toast.makeText(this, "Failed to submit form: ${e.message}", Toast.LENGTH_LONG).show()
            }
    }
}
