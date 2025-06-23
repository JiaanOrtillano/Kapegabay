package com.example.projectkape.fragments.Robusta

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import com.example.projectkape.databinding.FragmentRobustaClimateBinding

class RobustaClimateFragment : Fragment() {

    private var _binding: FragmentRobustaClimateBinding? = null
    private val binding get() = _binding!!

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentRobustaClimateBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.nextButton.setOnClickListener {
            (activity as? com.example.projectkape.Robusta)?.showNextFragment()
        }

        binding.backButton.setOnClickListener {
            (activity as? com.example.projectkape.Robusta)?.showPreviousFragment()
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
