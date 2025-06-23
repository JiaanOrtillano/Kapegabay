package com.example.projectkape

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import com.example.projectkape.fragments.Robusta.RobustaClimateFragment
import com.example.projectkape.fragments.Robusta.RobustaInfoFragment
import com.example.projectkape.fragments.Robusta.RobustaPlantingFragment

class Robusta : AppCompatActivity() {

    private var currentFragmentIndex = 0
    private val fragments = listOf(
        RobustaInfoFragment(),
        RobustaClimateFragment(),
        RobustaPlantingFragment()
    )

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_robusta)

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
