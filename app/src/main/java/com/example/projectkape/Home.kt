package com.example.projectkape

import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.widget.*
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.GravityCompat
import androidx.drawerlayout.widget.DrawerLayout
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class Home : AppCompatActivity() {

    private lateinit var drawerLayout: DrawerLayout
    private lateinit var adapter: CardAdapter
    private lateinit var recyclerView: RecyclerView
    private lateinit var searchBar: AutoCompleteTextView

    private var currentCategory: String = "All"

    private val items = listOf(
        CardItem(
            "Coffee Grounds for Insect Repellent...",
            "The benefit of using coffee grounds...",
            R.drawable.image_30,
            "All"
        ),
        CardItem(
            "Organic Fertilizer Tips",
            "Using coffee grounds as fertilizer...",
            R.drawable.image_31,
            "Videos"
        ),

    )

    private val suggestions = listOf(
        "Anong uri ng kape ang bagay sa malamig na lugar?",
        "Ano ang tamang distansya sa pagitan ng mga punong kape kapag nagtatanim?",
        "Kailan ang tamang panahon para magtanim ng kape?",
        "Paano ang tamang pag-aabono sa punong kape?",
        "Paano maiwasan ang peste gaya ng coffee berry borer?",
        "Ano ang magandang paraan ng pag-ani ng hinog na bunga ng kape?",
        "Ano ang ibig sabihin ng rejuvenation sa kape?",
        "Anong sakit ang nagdudulot ng pulbos na kulay kalawang sa ilalim ng dahon?",
        "Bakit mahalaga ang shade trees bago magtanim ng kape?",
        "Ano ang kaibahan ng Robusta, Arabica, Liberica, at Excelsa?",
        "Anong uri ng abono ang dapat gamitin sa organikong taniman?",
        "Ano ang mga palatandaan na ang bunga ng kape ay inatake ng insekto?",
        "Paano gawin ang side pruning sa kape?",
        "Bakit hindi dapat gamitin ang ihi o dumi ng tao bilang pataba?",
        "Gaano katagal bago mamunga ang punong kape?",
        "Anong uri ng lupa ang mas bagay sa kape?",
        "Kailangan bang diligan ang punong kape araw-araw?",
        "Pwede bang magtanim ng kape kahit tag-init?",
        "Ano ang ibig sabihin ng intercropping sa kape?",
        "Anong halamang pwede isabay sa taniman ng kape?",
        "Bakit kailangan putulan ang sanga ng punong kape?",
        "Gaano kahalaga ang pag-compost para sa taniman ng kape?",
        "Paano alagaan ang seedling ng kape sa unang buwan?",
        "Paano malalaman kung may root rot ang punong kape?",
        "Anong pestisidyo ang ligtas gamitin sa kape?",
        "Ilang kilo ng bunga ang inaabot ng isang punong kape kada taon?"
    )
    val questionToTopicMap = mapOf(
        "Anong uri ng kape ang bagay sa malamig na lugar?" to "Pagtatanim",
        "Ano ang tamang distansya sa pagitan ng mga punong kape kapag nagtatanim?" to "Pagtatanim",
        "Kailan ang tamang panahon para magtanim ng kape?" to "Paglilipat-tanim",
        "Paano ang tamang pag-aabono sa punong kape?" to "Pag-aabono (Fertilizing)",
        "Paano maiwasan ang peste gaya ng coffee berry borer?" to "Pagkokontrol ng Peste at Sakit",
        "Ano ang magandang paraan ng pag-ani ng hinog na bunga ng kape?" to "Pag-ani (Harvesting)",
        "Ano ang ibig sabihin ng rejuvenation sa kape?" to "Rejuvenation",
        "Anong sakit ang nagdudulot ng pulbos na kulay kalawang sa ilalim ng dahon?" to "Pagkokontrol ng Peste at Sakit",
        "Bakit mahalaga ang shade trees bago magtanim ng kape?" to "Pagtatanim",
        "Ano ang kaibahan ng Robusta, Arabica, Liberica, at Excelsa?" to "Mga Uri ng Kape",
        "Anong uri ng abono ang dapat gamitin sa organikong taniman?" to "Pag-aabono (Fertilizing)",
        "Ano ang mga palatandaan na ang bunga ng kape ay inatake ng insekto?" to "Pagkokontrol ng Peste at Sakit",
        "Paano gawin ang side pruning sa kape?" to "Pagpupungos o Pruning ng Kape",
        "Bakit hindi dapat gamitin ang ihi o dumi ng tao bilang pataba?" to "Pag-aabono (Fertilizing)",
        "Gaano katagal bago mamunga ang punong kape?" to "Mga Uri ng Kape",
        "Anong uri ng lupa ang mas bagay sa kape?" to "Mga Uri ng Kape",
        "Kailangan bang diligan ang punong kape araw-araw?" to "Mga Uri ng Kape",
        "Pwede bang magtanim ng kape kahit tag-init?" to "Paglilipat-tanim",
        "Ano ang ibig sabihin ng intercropping sa kape?" to "Pagtatanim",
        "Anong halamang pwede isabay sa taniman ng kape?" to "Pagtatanim",
        "Bakit kailangan putulan ang sanga ng punong kape?" to "Pagpupungos o Pruning ng Kape",
        "Gaano kahalaga ang pag-compost para sa taniman ng kape?" to "Pag-aabono (Fertilizing)",
        "Paano alagaan ang seedling ng kape sa unang buwan?" to "Pagtatanim",
        "Paano malalaman kung may root rot ang punong kape?" to "Pagkokontrol ng Peste at Sakit",
        "Anong pestisidyo ang ligtas gamitin sa kape?" to "Pagkokontrol ng Peste at Sakit",
        "Ilang kilo ng bunga ang inaabot ng isang punong kape kada taon?" to "Mga Uri ng Kape"
    )

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_home)

        drawerLayout = findViewById(R.id.drawer_layout)
        recyclerView = findViewById(R.id.recyclerView)
        searchBar = findViewById(R.id.search_bar)

        recyclerView.layoutManager = LinearLayoutManager(this)
        adapter = CardAdapter(items)
        recyclerView.adapter = adapter

        val searchAdapter = ArrayAdapter(this, android.R.layout.simple_dropdown_item_1line, suggestions)
        searchBar.setAdapter(searchAdapter)
        searchBar.threshold = 1

        searchBar.setOnItemClickListener { _, _, _, _ ->
            handleSearchSuggestion(searchBar.text.toString())
        }

        searchBar.addTextChangedListener(object : TextWatcher {
            override fun afterTextChanged(s: Editable?) {
                filterItems()
            }

            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
        })

        findViewById<ImageView>(R.id.menu_button).setOnClickListener {
            drawerLayout.openDrawer(GravityCompat.START)
        }
        findViewById<ImageView>(R.id.menuProfile).setOnClickListener {
            startActivity(Intent(this, Profile::class.java))
        }

        findViewById<TextView>(R.id.nav_home).setOnClickListener {
            drawerLayout.closeDrawer(GravityCompat.START)
        }
        findViewById<TextView>(R.id.nav_knowledge_hub).setOnClickListener {
            startActivity(Intent(this, KnowledgeHub::class.java))
        }
        findViewById<TextView>(R.id.nav_forms).setOnClickListener {
            startActivity(Intent(this, FormsActivity::class.java))
        }
        findViewById<TextView>(R.id.nav_farm_calendar).setOnClickListener {
            startActivity(Intent(this, FarmCalendar::class.java))
        }
        findViewById<TextView>(R.id.nav_notifications).setOnClickListener {
            startActivity(Intent(this, NotificationsActivity::class.java))
        }
        findViewById<TextView>(R.id.nav_support).setOnClickListener {
            startActivity(Intent(this, SupportActivity::class.java))
        }
        findViewById<TextView>(R.id.nav_about).setOnClickListener {
            startActivity(Intent(this, AboutActivity::class.java))
        }

        findViewById<TextView>(R.id.tab_all).setOnClickListener {
            currentCategory = "All"
            filterItems()
        }
        findViewById<TextView>(R.id.tab_videos).setOnClickListener {
            currentCategory = "Videos"
            filterItems()
        }

    }

    private fun handleSearchSuggestion(query: String) {
        val topic = questionToTopicMap[query]
        if (topic != null) {
            val intent = Intent(this, KnowledgeDetailActivity::class.java)
            intent.putExtra("title", topic)
            startActivity(intent)
        } else {
            filterItems() // fallback to regular search filtering
        }
    }

    private fun filterItems() {
        val query = searchBar.text.toString().trim()

        val filtered = items.filter {
            val matchesCategory = currentCategory == "All" || it.tagLabel == currentCategory
            val matchesSearch = query.isEmpty() ||
                    it.title.contains(query, ignoreCase = true) ||
                    it.description.contains(query, ignoreCase = true)
            matchesCategory && matchesSearch
        }

        val result = if (currentCategory == "Vlog") {
            filtered.filter { it.youtubeUrl != null }
        } else {
            filtered
        }

        adapter.updateList(result)
    }
}
