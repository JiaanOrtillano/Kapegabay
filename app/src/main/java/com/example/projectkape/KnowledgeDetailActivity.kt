package com.example.projectkape

import android.os.Bundle
import android.widget.ImageButton
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity

class KnowledgeDetailActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_knowledge_detail)

        val backButton = findViewById<ImageButton>(R.id.menuBack)
        val titleTextView = findViewById<TextView>(R.id.detailTitle)
        val contentTextView = findViewById<TextView>(R.id.detailContent)

        val title = intent.getStringExtra("title")
        titleTextView.text = title

        val content = when (title) {
            "Mga uri ng kape" -> "Iba’t ibang uri ng kape: Arabica, Robusta, Liberica, atbp."
            "Paglilipat-tanim" -> "Paraan ng ligtas at epektibong paglilipat-tanim."
            "Pag-aabono (Fertilizing)" -> "Gabay sa tamang abono at dami ng ilalagay."
            "Pruning ng Kape (Maintenance Pruning)" -> "Paano at kailan mag-prune ng puno ng kape."
            "Rejuvenation" -> "Proseso ng pagbibigay-buhay muli sa matandang puno ng kape."
            "Pagsusuri or Pagsasala (Sorting)" -> "Pagkakahiwalay ng mabuti at sirang butil ng kape."
            "Pag-uuri ayon sa kalidad (Grading)" -> "Pag-uuri ng kape batay sa laki, kulay, at anyo."
            "Pagsasangag (Roasting)" -> "Paano ang tamang paraan ng pagsangag ng kape."
            "Mga Depekto sa Kape (Coffee defects)" -> "Mga karaniwang depekto gaya ng insect damage, sour beans, atbp."
            "Pagkontrol sa mga Peste at Sakit" -> "Pagkilala at pagpuksa sa peste at sakit ng kape."
            else -> "Walang impormasyon."
        }

        contentTextView.text = content

        backButton.setOnClickListener {
            finish()
        }
    }
}
