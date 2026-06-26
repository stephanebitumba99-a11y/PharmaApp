import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './layout.html',
  styleUrls: ['./layout.css']
})
export class LayoutComponent {

  constructor() {
    console.log("✅ Layout chargé");
  }

  menu = [
    {
      label: 'Dashboard',
      link: '/layout/dashbord',
      icon: '📊'
    },
    {
      label: 'Produits',
      link: '/layout/produit',
      icon: '💊'
    },
    {
      label: 'Pharmaciens',
      link: '/layout/pharmacien',
      icon: '👨‍⚕️'
    }
  ];

  user = {
    name: 'Admin'
  };

  dropdownOpen = false;

  toggleDropdown() {
    this.dropdownOpen = !this.dropdownOpen;
  }

  // Fermer le dropdown en cliquant ailleurs
  closeDropdown() {
    this.dropdownOpen = false;
  }
}