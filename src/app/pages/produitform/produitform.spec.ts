import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Produitform } from './produitform';

describe('Produitform', () => {
  let component: Produitform;
  let fixture: ComponentFixture<Produitform>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Produitform]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Produitform);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
