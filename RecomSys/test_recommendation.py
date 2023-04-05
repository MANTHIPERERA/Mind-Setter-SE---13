import unittest

class TestRecommendations(unittest.TestCase):

    def setUp(self):
        self.app = app.test_client()

    def test_Button(self):
        response = self.app.get('/ButtonPage/')
        self.assertEqual(response.status_code, 200)
        print("Button test passed")

    def test_BuildAntiTestSetForUser(self):
        trainset = ml.loadMovieLensLatestSmall()
        anti_testset = BuildAntiTestSetForUser(1, trainset)
        self.assertIsInstance(anti_testset, list)
        print("BuildAntiTestSetForUser test passed")

    def test_home(self):
        response = self.app.get('/recommendations/1')
        self.assertEqual(response.status_code, 200)
        self.assertIn(b"We recommend:", response.data)
        print("Home test passed")

if __name__ == '__main__':
    unittest.main()



    
