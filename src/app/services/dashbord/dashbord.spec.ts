import { TestBed } from '@angular/core/testing';

import { Dashbord } from './dashbord';

describe('Dashbord', () => {
  let service: Dashbord;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Dashbord);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
