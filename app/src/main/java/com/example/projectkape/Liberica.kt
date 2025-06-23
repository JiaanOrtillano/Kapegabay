package com.example.projectkape

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import com.example.projectkape.fragments.Liberica.LibericaClimateFragment
import com.example.projectkape.fragments.Liberica.LibericaInfoFragment
import com.example.projectkape.fragments.Liberica.LibericaPlantingFragment

class Liberica : AppCompatActivity() {

    private var currentFragmentIndex = 0
    private val fragments = listOf(
        LibericaInfoFragment(),
        LibericaClimateFragment(),
        LibericaPlantingFragment()
    )

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_liberica)

        showFragment(currentFragmentIndex)

        // OPTIONAL: Add listeners to buttons like “Susunod” / “←” here if using them
    }

    private fun showFragment(index: Int) {
        supportFragmentManager.beginTransaction()
            .replace(R.id.fragmentContainer, fragments[index])
            .commit()
    }

    fun showNextFragment() {
        if (currentFragmentIndex < fragments.size - 1) {
            currentFragmentIndex++
            showFragment(currentFragmentIndex)
        }
    }

    fun showPreviousFragment() {
        if (currentFragmentIndex > 0) {
            currentFragmentIndex--
            showFragment(currentFragmentIndex)
        }
    }
}
