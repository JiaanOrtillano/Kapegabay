package com.example.projectkape.fragments.Excelsa

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import com.example.projectkape.databinding.FragmentExcelsaClimateBinding

class ExcelsaClimateFragment : Fragment() {

    private var _binding: FragmentExcelsaClimateBinding? = null
    private val binding get() = _binding!!

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentExcelsaClimateBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.nextButton.setOnClickListener {
            (activity as? com.example.projectkape.Excelsa)?.showNextFragment()
        }

        binding.backButton.setOnClickListener {
            (activity as? com.example.projectkape.Excelsa)?.showPreviousFragment()
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
