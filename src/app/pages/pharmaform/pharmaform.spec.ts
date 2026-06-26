import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Pharmaform } from './pharmaform';

describe('Pharmaform', () => {
  let component: Pharmaform;
  let fixture: ComponentFixture<Pharmaform>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Pharmaform]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Pharmaform);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
