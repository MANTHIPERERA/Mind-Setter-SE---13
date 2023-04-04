import unittest
from unittest.mock import MagicMock, patch
from flask import Flask
from app.views import views

class TestRecommendations(unittest.TestCase):

    def setUp(self):
        app = Flask(__name__)
        app.register_blueprint(views)
        self.client = app.test_client()

    @patch("app.views.MovieLens")
    @patch("app.views.SVD")
    def test_home(self, mock_svd, mock_movielens):
        # Set up the mocks
        mock_movielens_inst = MagicMock()
        mock_svd_inst = MagicMock()
        mock_movielens.return_value = mock_movielens_inst
        mock_svd.return_value = mock_svd_inst

        # Set up the test data
        user_id = "1"
        mock_movielens_inst.loadMovieLensLatestSmall.return_value = "test_data"
        mock_movielens_inst.getUserRatings.return_value = [("1", "5"), ("2", "4"), ("3", "2"), ("4", "1")]

        # Call the Flask route
        response = self.client.get(f"/recommendations/{user_id}")
        self.assertEqual(response.status_code, 200)

        # Check the mock method calls
        mock_movielens_inst.loadMovieLensLatestSmall.assert_called_once()
        mock_movielens_inst.getUserRatings.assert_called_once_with(1)
        mock_svd_inst.fit.assert_called_once()
        mock_svd_inst.test.assert_called_once()
        mock_movielens_inst.getMovieName.assert_called()

        if __name__ == '__main__':
            unittest.main()

    
