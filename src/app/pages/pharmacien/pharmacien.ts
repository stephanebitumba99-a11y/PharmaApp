import { Component, OnInit, signal, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PharmacienService } from '../../services/pharmacien/pharmacien';
import { RouterLink } from "@angular/router";

@Component({
  selector: 'app-pharmacien',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './pharmacien.html',
  styleUrls: ['./pharmacien.css']
})
export class PharmacienComponent implements OnInit {

  // 🔥 SIGNALS
  pharmaciens = signal<any[]>([]);
  search = signal('');

  // 🔥 DELETE
  deleteId: number | null = null;
  isDeleting = false;

  constructor(private pharmacienService: PharmacienService) {}

  ngOnInit(): void {
    this.loadPharmaciens();
  }

  // 🔥 LOAD DATA
  loadPharmaciens() {
    this.pharmacienService.getPharmaciens().subscribe({
      next: (res: any) => {
        this.pharmaciens.set(res.data ?? res);
      },
      error: (err: any) => console.log(err)
    });
  }

  // 🔥 SEARCH FILTER (SAME STYLE AS PRODUITS)
filteredPharmaciens = computed(() => {

  const value = this.search().toLowerCase().trim();

  if (!value) return this.pharmaciens();

  return this.pharmaciens().filter(p => {

    const fullName = `${p.Name ?? ''} ${p.First_name ?? ''}`.toLowerCase().trim();

    return fullName.startsWith(value);

  });

});

updateSearch(event: Event) {

  const input = event.target as HTMLInputElement;

  this.search.set(input.value);
}

  // 🔥 DELETE
  deletePharmacien(id: number) {
    this.deleteId = id;
    this.isDeleting = true;
  }

  confirmDelete() {
    if (!this.deleteId) return;

    this.pharmacienService.deletePharmacien(this.deleteId).subscribe({
      next: () => {
        this.loadPharmaciens();
        this.cancelDelete();
      }
    });
  }

  cancelDelete() {
    this.deleteId = null;
    this.isDeleting = false;
  }
}